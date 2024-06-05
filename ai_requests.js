import { addTypingAnimation } from "./script.js";
export function generateResponse(prompt,element) {
    element = element || "";

    if(element != ""){
        addTypingAnimation(element);
    }
    if(navigator.onLine){
        let data = {
            "text": prompt
        }
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "server/router.php", true);
        xhr.onload = async ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    element != "" ? element.innerHTML = data : null;
                    
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`type=chatAi&data=${JSON.stringify(data)}`);
    }
}

export function analyseImage(image,element){
    addTypingAnimation(element);

    var fileReader = new FileReader();
    console.log(image);

    fileReader.onload = function(fileLoadedEvent) {
        var base64 = fileLoadedEvent.target.result;
        
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "server/router.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = () => {
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    element != "" ? element.innerHTML = data : null;
                }
            }
        }
        xhr.send("type=analyseImage&image=" + encodeURIComponent(base64));
    };

    fileReader.readAsDataURL(image);
}
