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
    var el = document.getElementById('ViewContainer');
    el.style = "visibility:visible;opacity:1;";
    document.getElementById("VIewBox").innerHTML = '<img src="'+e.src+'"/><i></i>';
    el.onclick = ()=>{
        document.getElementById('ViewContainer').style = "opacity: 0;visibility: hidden;";
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

function Search(e,h,base){
    if(e.keyCode == 13){
        if(h.value.replace(" ",'').length > 3)
            window.location = "?c="+h.value.replace(" ","%20");
        else{
            var el = document.getElementById('cProfile');
            el.style.display = "block";
            el.innerHTML = "<b>No Unique Data found or No Data found.<br>Try to add More Words.</b>";
        }
    }
    if(h.value.length > 3){
        var xhr = new XMLHttpRequest();
        xhr.onload = function () {
            if (xhr.readyState === xhr.DONE && xhr.status === 200) {
                var json = JSON.parse(xhr.responseText);
                var tmp = "";
                var  el = document.getElementById('suggestion');
                el.innerHTML = "";
                for(var i=0;i<json.length;i++){
                    tmp +=`<option value="${json[i]}"></option>`;
                }
                el.innerHTML = tmp;
            }
        };
        xhr.open("get", base+"/clg/autocomplete/"+h.value, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send();
    }
}

function ClearSearch(){
    document.querySelectorAll('[elem-style="SearchBox"]')[0].value = "";
    document.getElementById('suggestion').innerHTML = "";
}