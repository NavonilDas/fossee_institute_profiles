(function ($) {
    $(function () {
        $.fn.search = function(data){
            window.location += '?c='+data;
        }
    });
})(jQuery);
function viewImage(e){
    var el = document.getElementById('VIewBox');
    el.style.display = "flex";
    el.innerHTML = '<img src="'+e.src+'"/><label>X</label>';
    el.onclick = ()=>{
        document.getElementById('VIewBox').style.display = "none";
    }
}