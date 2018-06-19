(function ($) {
    $(function () {
        $.fn.DIsplayNone = function(){
            var el = document.getElementById('cProfile');
            el.style.display = "block";
            el.innerHTML = "<b>No Unique Data found or No Data found.<br>Try to add More Words.</b>";
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

function ChangeTab(id){
    var el = document.querySelectorAll('#thetabs > li');
    if(el){
        for(var i=1;i<=6;i++){
            if(i != id){
                el[i-1].classList.remove('active');
                document.getElementById('thedata-'+i).style.display = 'none';
            }
        }
        el[id-1].classList.add('active');
    }
    document.getElementById('thedata-'+id).style.display = 'block';

}

function Search(e,h){
    if(e.keyCode == 13){
        if(h.value.replace(" ",'').length > 3)
            window.location = "?c="+h.value.replace(" ","%20");
        else{
            var el = document.getElementById('cProfile');
            el.style.display = "block";
            el.innerHTML = "<b>No Unique Data found or No Data found.<br>Try to add More Words.</b>";
        }
    }
}