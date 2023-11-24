<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index(){
        $setting = Setting::first();
        if(!$setting){
            $setting = new Setting();
            $setting->save();
        }
        $tokens = Token::orderByDesc('created_at')->get();
        $products = Product::orderByDesc('created_at')->get();
        return view('admin.index', ['setting' => $setting, 'tokens' => $tokens, 'products' => $products]);
    }

    //tokens
    public function createToken(){
        return view('admin.tokens.create');
    }
    public function storeToken(Request $request){
        $request->validate([
            'icon' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'name' => ['required', 'string'],
            'ticker' => ['required', 'string'],
            'contract_address' => ['required', 'string', 'unique:tokens']
        ]);
        $icon_name = time().'_icon.'.$request->icon->extension();
        $request->icon->move(public_path('images'), $icon_name);
        Token::create([
            'name' => $request->name,
            'contract_address' => $request->contract_address ,
            'ticker' => $request->ticker,
            'icon' => $icon_name,
        ]);
        session()->flash('success_message', 'Token Added successfully');
        return back();
    }
    public function updateToken(Request $request, Token $token){
        $request->validate([
            'icon' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'name' => ['required', 'string'],
            'ticker' => ['required', 'string'],
            'contract_address' => ['required', 'string']
        ]);
        $token->update([
            'name' => $request->name,
            'ticker' => $request->ticker,
            'contract_address' => $request->contract_address
        ]);
        if($request->icon){
            $icon_name = time().'_icon.'.$request->icon->extension();
            $request->icon->move(public_path('images'), $icon_name);
            $token->icon = $icon_name;
            $token->save();
        }
        session()->flash('success_message', 'Token Updated successfully');
        return back();
    }
    public function editToken(Token $token){
        return view('admin.tokens.edit', ['token' => $token]);
    }
    public function deleteToken(Token $token){
        try{
            $token->delete();
            session()->flash('success_message', 'Token deleted');
        }catch (\Exception $e){
            Log::info('delete token error: '.$e->getMessage());
            session()->flash('something went wrong');
        }
        return back();
    }

    //products
    public function createProduct(){
        return view('admin.products.create');
    }
    public function storeProduct(Request $request){
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0.1',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $image_name = time().'_product.'.$request->image->extension();
        $request->image->move(public_path('images'), $image_name);
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $image_name
        ]);
        session()->flash('success_message', 'Product added successfully');
        return back();
    }
    public function editProduct(Product $product){
        return view('admin.products.edit', ['product' => $product]);
    }
    public function updateProduct(Request $request, Product $product){
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0.1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        $product->update([
            'name' => $request->name,
            'price' => $request->price
        ]);
        if($request->image){
            $image_name = time().'_product.'.$request->image->extension();
            $request->image->move(public_path('images'), $image_name);
            $product->image = $image_name;
            $product->save();
        }
        session()->flash('success_message', 'Product updated successfully');
        return back();
    }
    public function deleteProduct(Product $product){
        try{
            $product->delete();
            session()->flash('success_message', 'product deleted');
        }catch (\Exception $e){
            Log::info('delete product error: '.$e->getMessage());
            session()->flash('something went wrong');
        }
        return back();
    }

    public function updateSettings(Request $request){
        $request->validate([
            'destination_address' => 'required|string'
        ]);
        $setting = Setting::first();
        $setting->destination_address = $request->destination_address;
        $setting->save();
        session()->flash('success_message', Lang::get('Destination address updated'));
        return back();
    }
}
