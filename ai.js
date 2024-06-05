import { addTypingAnimation, showError,useToggle,showNotif } from "./script.js";
import { analyseImage } from './ai_requests.js';

var messageCurrentTimestamp = null,currentImageForAi = null;

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
        element.addEventListener("click", () => {
            document.getElementById("chat_screen").style.display = "flex";
            document.getElementById("chat_area").innerHTML = "";
            document.getElementById("chat_area").innerHTML = `<div class = "flex-column flex-column-reverse" id="previous_chat_area"></div>`;

            //initialise loading screen in the chat screen before messages load
            let loadingTextDiv = document.createElement("div");
            loadingTextDiv.innerText = "Getting your messages...";
            loadingTextDiv.style.margin = "auto";
            loadingTextDiv.style.width = "fit-content";
            loadingTextDiv.style.marginTop = "100px";
            loadingTextDiv.classList.add("flex-column","align-center");
            let inner_div = document.createElement("div");
            inner_div.style.marginTop = "20px";
            inner_div.classList.add("typing-indicator");
            for (let i = 0; i < 3; i++) {
                let dot = document.createElement("div");
                dot.classList.add("typing-dot");
                inner_div.appendChild(dot);
            }
            loadingTextDiv.appendChild(inner_div);
            document.getElementById("chat_area").appendChild(loadingTextDiv);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "server/router.php", true);
            xhr.onload = ()=>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response;
                        console.log(data);
                        try {
                            JSON.parse(data);
                            data = JSON.parse(data);
                            document.getElementById("chat_area").removeChild(loadingTextDiv);

                            let container = document.createElement("div");
                            container.classList.add("flex-column","flex-column-reverse");
                            for (let i = 0; i < data.length; i++) {
                                let user = data[i]['sender'],text = data[i]['message'];
                                let div = document.createElement("div");
                                div.classList.add("flex-row");
                                user == "person" && div.classList.add('flex-end');

                                let inner_div = document.createElement("div");
                                inner_div.classList.add("message");
                                user == "person" ? inner_div.classList.add('user_chat') : inner_div.classList.add('ai_chat');
                                inner_div.innerHTML = text;
                                div.appendChild(inner_div);
                                container.appendChild(div);
                            }

                            document.getElementById("previous_chat_area").appendChild(container);
                            document.getElementById("chat_area").scrollTop = document.getElementById("chat_area").scrollHeight;

                            if(data.length > 0){
                                messageCurrentTimestamp = data[data.length-1]["timestamp"];
                            }
                        } catch (error) {
                            showNotif(["fa-exclamation-circle","error"], data);
                        }
                        
                    }
                }
            }
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send(`type=getMessages&timestamp=${messageCurrentTimestamp}`);

        });
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
        let imageURL = window.URL.createObjectURL(event.dataTransfer.files[0]), image = event.dataTransfer.files[0];
        document.getElementById("upload_div").style.backgroundImage = `url('${imageURL}')`;
        document.getElementById("upload_file_text").innerText = "";
        document.getElementById("analyse_image_btn").removeAttribute("disabled");
        currentImageForAi = image;
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
        let imageURL = window.URL.createObjectURL(document.getElementById("image_file_upload_btn").files[0]), image = document.getElementById("image_file_upload_btn").files[0];
        document.getElementById("upload_div").style.backgroundImage = `url('${imageURL}')`;
        document.getElementById("upload_file_text").innerText = "";
        document.getElementById("analyse_image_btn").removeAttribute("disabled");
        currentImageForAi = image;
    } catch (error) {
        showError(error);
        console.error(error);
    }
}

function generateResponse(prompt) {
    let div = document.createElement("div");
    div.classList.add("ai_chat","message","flex-row");
    let inner_div = document.createElement("div");
    inner_div.classList.add("typing-indicator");
    for (let i = 0; i < 3; i++) {
        let dot = document.createElement("div");
        dot.classList.add("typing-dot");
        inner_div.appendChild(dot);
    }
    div.appendChild(inner_div);

    document.getElementById("chat_area").appendChild(div);
    document.getElementById("chat_area").scrollTop = document.getElementById("chat_area").scrollHeight;
    if(navigator.onLine){
        let data = {
            "text": prompt
        }
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "server/router.php", true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    console.log(data);

                    document.getElementById("chat_area").removeChild(div);
    
                    addMessage(data,'bot');
                    
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`type=chatAi&data=${JSON.stringify(data)}`);
    }
}

function addMessage(text, user){
    let div = document.createElement("div");
    div.classList.add("flex-row");
    user == "person" && div.classList.add('flex-end');

    let inner_div = document.createElement("div");
    inner_div.classList.add("message");
    user == "person" ? inner_div.classList.add('user_chat') : inner_div.classList.add('ai_chat');
    inner_div.innerHTML = text;
    div.appendChild(inner_div);

    document.getElementById("chat_area").appendChild(div);
    document.getElementById("chat_area").scrollTop = document.getElementById("chat_area").scrollHeight;

    if(navigator.onLine){
        let date = new Date();
        let data = {
            'sender': user,
            'message': text,
            'timestamp': `${date.getFullYear()}${date.getMonth()}${date.getDate()}${date.getHours()}${date.getMinutes() < 10 ? "0" + date.getMinutes().toString() : date.getMinutes()}${date.getSeconds() < 10 ? "0" + date.getSeconds().toString() : date.getSeconds()}`
        };
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "server/router.php", true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    console.log(data);
                    if(data != true){
                        showNotif(["fa-exclamation-circle","error"],data);
                    }
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`type=insertMessage&data=${JSON.stringify(data)}`);
    }
    else{
        showNotif(["fa-exclamation-circle","error"],"You seem to be offline.");
    }
}

function sendMessage(userInput) {
    if (!userInput) return;

    document.getElementById('chat_input').value = '';
    document.getElementById("chat_send_btn").setAttribute("disabled",true);
    let text =  userInput;
    generateResponse("You are a professional healthcare assitant: "+text);
}

document.getElementById("chat_input").addEventListener("input",() => {
    if(document.getElementById("chat_input").value.length > 1){
        document.getElementById("chat_send_btn").removeAttribute("disabled");
    }
    else{
        document.getElementById("chat_send_btn").disabled = true;
    }
});

document.getElementById("close_chat_btn").addEventListener("click",() => {
    document.getElementById("chat_screen").style.display = "none";
    messageCurrentTimestamp = null;
});

document.getElementById("image_file_upload_btn").addEventListener("drop",processImageDrop);
document.getElementById("image_file_upload_btn").addEventListener("change",processImage);

useToggle(document.getElementById("error_div_text"), document.getElementById("main_err_close_btn"), document.getElementById("main_error_div"));

document.getElementById("close-image-analyser-div").addEventListener("click",toggleImageAnalyser);
document.getElementById("chat_send_btn").addEventListener("click",() => {
    let userInput = document.getElementById("chat_input").value;
    addMessage(userInput, "person");
    sendMessage(userInput);
});


document.getElementById("take_pic_btn").addEventListener("click", async function(){
    let cameraStream = document.getElementById("camera_stream");
    let takePicBtn = document.getElementById("take_pic_btn");

    if(takePicBtn.dataset.text == "toggle"){
        takePicBtn.setAttribute("disabled",true);
        cameraStream.style.display = "block";

        takePicBtn.dataset.text = "click";

        let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
        cameraStream.srcObject = stream;

        takePicBtn.innerText = "Take Picture";
        document.getElementById("upload_file_text").innerText = "";
        takePicBtn.removeAttribute("disabled");
    }
    else{
        takePicBtn.dataset.text = "toggle";
        let canvas = document.createElement("canvas");
        canvas.width = cameraStream.clientWidth;
        canvas.height = cameraStream.clientHeight;
        let drawImage = canvas.getContext('2d').drawImage(cameraStream,0, 0, canvas.width, canvas.height);
        console.log(drawImage);
        console.log(window.URL.createObjectURL(drawImage));
        document.getElementById("upload_div").style.backgroundImage = `url('${window.URL.createObjectURL(drawImage)}')`;
        cameraStream.style.display = "none";
        takePicBtn.innerText = "Toggle camera";
    }
});

document.getElementById("chat_area").addEventListener("scroll", () => { 
    if(document.getElementById("chat_area").scrollTop == 0){
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "server/router.php", true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    console.log(data);
                    try {
                        JSON.parse(data);
                        data = JSON.parse(data);

                        let container = document.createElement("div");
                        container.classList.add("flex-column","flex-column-reverse");
                        for (let i = 0; i < data.length; i++) {
                            let user = data[i]['sender'],text = data[i]['message'];
                            let div = document.createElement("div");
                            div.classList.add("flex-row");
                            user == "person" && div.classList.add('flex-end');

                            let inner_div = document.createElement("div");
                            inner_div.classList.add("message");
                            user == "person" ? inner_div.classList.add('user_chat') : inner_div.classList.add('ai_chat');
                            inner_div.innerHTML = text;
                            div.appendChild(inner_div);
                            container.appendChild(div);
                        }

                        document.getElementById("previous_chat_area").appendChild(container);
                        document.getElementById("chat_area").scrollTop = document.getElementById("chat_area").scrollTop;

                        if(data.length > 0){
                            messageCurrentTimestamp = data[data.length-1]["timestamp"];
                        }
                    } catch (error) {
                        showNotif(["fa-exclamation-circle","error"], data);
                        console.error(error);
                    }
                    
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`type=getMessages&timestamp=${messageCurrentTimestamp}`);
    }
});

document.getElementById("analyse_image_btn").addEventListener("click",() => {
    analyseImage(currentImageForAi, document.getElementById("ai_analyse_image_text"));
});