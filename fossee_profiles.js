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
    if(document.getElementById('clgName'))
    document.getElementById('clgName').addEventListener("keyup", function(event) {
        if(event.which == 8){
            document.getElementById('suggest').innerHTML = "";
        }
      }
    );
}

function AddTOList(e){
    var sgst = document.getElementById('suggest');
    sgst.innerHTML = "";
    // var len = sci_lab_m.length; // Scilab Lab Migration Proposal
    // for(var i=0;i<len;i++){
    //     if(sci_lab_m[i].university.toLowerCase().indexOf(e.value.toLowerCase()) !== -1){
    //         sgst.innerHTML += sci_lab_m[i].university + "<br>";
    //     }
    // }
    searching(sci_lab_m,e.value,sgst);
    searching(sci_lab_text,e.value,sgst);
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
    
}

function viewImage(e){
    
    var el = document.getElementById('VIewBox');
    el.style.display = "flex";
    el.innerHTML = '<img src="'+e.src+'"/><label>X</label>';
    el.onclick = ()=>{
        document.getElementById('VIewBox').style.display = "none";
    }
}