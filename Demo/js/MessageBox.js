let MessageBox_parent = document.getElementById("MessageBox_parent"),
    MessageBox_innerBox = document.querySelector("#MessageBox_parent > div");

MessageBox_parent.onclick = function(){ 
    this.classList.add("hidden");
}

if(MessageBox_innerBox != null){
MessageBox_innerBox.onclick = function(e){
    e.stopPropagation();
}
}
