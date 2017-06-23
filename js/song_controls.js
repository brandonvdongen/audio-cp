const php = "php/song_controls.js";

function play(){
    console.log("play");
}
function stop(){
    console.log("stop");
}
function load_id(id){
    console.log("load",id);
    Post("lsl/control.php","load_id="+id,function(e){
        console.log(e.response);
    });
}
function edit_id(id){
    console.log("edit",id);
}
function delete_id(id){
    console.log("delete",id);
}