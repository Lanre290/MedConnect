import { showError,useToggle } from "./script.js";

function toggleImageAnalyser(){
    if(document.getElementById("upload_image_div").dataset.display == "none"){
        document.getElementById("upload_image_div").style.display = "flex";
        document.getElementById("home_div").style.display = "none";
        document.getElementById("upload_image_div").dataset.display = "flex";
    }
    else{
        document.getElementById("upload_image_div").style.display = "none";
        document.getElementById("home_div").style.display = "flex";
        document.getElementById("upload_image_div").dataset.display = "none";
    }
}
document.querySelectorAll(".ai_placcard").forEach(element => {
    if(element.id == "toggle-chat-div"){
        //do something
    }
    else{
        element.addEventListener("click", toggleImageAnalyser);
    }
});


function processImageDrop(event){
    try {
        if(event.dataTransfer.files[0].size == 0){
            throw new Error('invalid file');
        }
        if(!(event.dataTransfer.files[0].type.includes("image"))){
            throw new Error('Invalid file type');
        }
        document.getElementById("upload_div").style.backgroundImage = `url('${window.URL.createObjectURL(event.dataTransfer.files[0])}')`;
        document.getElementById("upload_file_text").innerText = "";
        document.getElementById("analyse_image_btn").removeAttribute("disabled");
    } catch (error) {
        showError(error);
    }
}

function processImage(event){
    try {
        if(document.getElementById("image_file_upload_btn").files[0].size == 0){
            throw new Error('invalid file');
        }
        if(!(document.getElementById("image_file_upload_btn").files[0].type.includes("image"))){
            throw new Error('Invalid file type');
        }
        document.getElementById("upload_div").style.backgroundImage = `url('${window.URL.createObjectURL(document.getElementById("image_file_upload_btn").files[0])}')`;
        document.getElementById("upload_file_text").innerText = "";
        document.getElementById("analyse_image_btn").removeAttribute("disabled");
    } catch (error) {
        showError(error);
        console.error(error);
    }
}

document.getElementById("image_file_upload_btn").addEventListener("drop",processImageDrop);
document.getElementById("image_file_upload_btn").addEventListener("change",processImage);

useToggle(document.getElementById("error_div_text"), document.getElementById("main_err_close_btn"), document.getElementById("main_error_div"));
document.getElementById("close-image-analyser-div").addEventListener("click",toggleImageAnalyser);