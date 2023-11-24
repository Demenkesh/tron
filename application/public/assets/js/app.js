"use strict";

var backToTop = document.getElementById('back-to-top')
window.onscroll = function () {
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        backToTop.style.display = 'block'
    } else {
        backToTop.style.display = 'none'
    }
}

backToTop.onclick = function (e) {
    window.scrollTo({ top: 0, behavior: 'smooth' })
}