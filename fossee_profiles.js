(function ($) {
    $(function () {
        $.fn.DIsplayNone = function(){
            var el = document.getElementById('cProfile');
            el.style.display = "block";
            el.innerHTML = "<b>No Data Found Try to add More Words!</b>";
        }
        $.fn.DisplayData = function(data){
                var el = document.getElementById('cProfile');
                el.style.display = "block";
                el.innerHTML = data;
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