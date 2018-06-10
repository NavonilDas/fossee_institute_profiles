/**
 * 
 * 
 * sci_lab_text
 * sci_lab_m
 * document.addEventListener("keydown", function(event) {
  console.log(event.which);
}
 */
(function ($) {
    $(function () {
        $.fn.diplayData = function(data){
        }
    });
})(jQuery);

window.onload = ()=>{
    setPos();
    if(document.getElementById('clgName'))
    document.getElementById('clgName').addEventListener("keyup", function(event) {
        if(event.which == 8){
            document.getElementById('suggest').innerHTML = "";
        }else{
        }

      }
    );
}
window.onresize = () =>{
    setPos();
}
function setPos(){
    var e = document.getElementById('clgName');
    var x = document.getElementById('suggest');
    console.log(e);
    x.style.left = e.offsetLeft+"px";
    x.style.top = (e.offsetTop+e.offsetHeight-2)+"px";
    
}
function AddTOList(e){
    if(e.value.length > 2){
        var sgst = document.getElementById('suggest');
        sgst.innerHTML = "";
        searching(sci_lab_m,e.value,sgst);
        searching(sci_lab_text,e.value,sgst);
    }
}

function searching(data,val,sgst){
    var len = data.length; // Scilab Lab Migration Proposal
    for(var i=0;i<len;i++){
        if(data[i].university.toLowerCase().indexOf(val.toLowerCase()) !== -1){
            sgst.innerHTML += '<a href="?c='+data[i].university+'" >' + data[i].university + "</a><br>";
        }
    }
}

function Display(){
    document.getElementById('result');
}

function clearSgst(e){
    console.log(e.KeyCode);
}

function search(){
    window.location += '?c='+document.getElementById('clgName').value;
}

function viewImage(e){
    var el = document.getElementById('VIewBox');
    el.style.display = "flex";
    el.innerHTML = '<img src="'+e.src+'"/><label>X</label>';
    el.onclick = ()=>{
        document.getElementById('VIewBox').style.display = "none";
    }
}