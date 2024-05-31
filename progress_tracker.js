import {useToggle,showError} from './script.js';

const canvas = document.getElementById("progress_chart");
const progressChartCtx = canvas.getContext('2d');
const chartArea = document.getElementById("pt_chart_area");

canvas.width = chartArea.clientWidth;
canvas.height = chartArea.clientHeight;

progressChartCtx.fillStyle = 'black';
progressChartCtx.strokeStyle = 'black';
progressChartCtx.lineWidth = 0.4;



useToggle(document.getElementById("track_new_progress_btn"), document.getElementById("tp_add_new_close_btn"), document.getElementById("tp_add_new_bc"));
useToggle(document.getElementById("tp_enter_new_value"), document.getElementById("tp_ent_val_close_btn"), document.getElementById("tp_ent_val_bc"));
useToggle(document.getElementById("error_div_text"), document.getElementById("main_err_close_btn"), document.getElementById("main_error_div"));


function updateNewProgress(){
    let value = document.getElementById("tp_add_new_value");
    let description = document.getElementById("tp_add_new_desc");
    let currentProgress = document.getElementById("current_progress")
    let error = 0;

    [value, description, currentProgress].forEach(element => {
        if(element.value.length < 1){
            error++;
            element.classList.add("custom_input_err");
            element.addEventListener("click",() => {
                if(element.value.length < 1){
                    element.classList.add("custom_input_err");
                }
                else{
                    element.classList.remove("custom_input_err");
                }
        });
        }
    });

    let date = new Date();
    const months = ['Jan','Feb','Mar','Apr','May','Jun','jul','Aug','Sep','Oct','Nov','Dec'];
    
    let data = {
        "value": value.value,
        "description": description.value,
        "date": `${date.getDate()}-${months[date.getMonth()]}-${date.getFullYear()}`,
        "current_progress": currentProgress.value,
        "timestamp": `${date.getFullYear()}${date.getMonth()}${date.getDate()}${date.getHours()}${date.getMinutes() < 10 ? "0" + date.getMinutes().toString() : date.getMinutes()}${date.getSeconds() < 10 ? "0" + date.getSeconds().toString() : date.getSeconds()}`
    }

    console.log(data);

    if(error == 0){
        let xhr = new XMLHttpRequest();
        document.getElementById("loading_screen").style.display = "block";
        xhr.open("POST", "server/router.php", true);
        xhr.onprogress = () => {
            document.getElementById("loading_bar").style.width = `${(xhr.readyState/xhr.DONE)*100}%`;
        }
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    document.getElementById("loading_bar").style.width = "100%";
                    document.getElementById("loading_screen").style.display = "none";
                    document.getElementById("tp_ent_val_bc").style.display = "none";

                    console.log(data);
                    if(data != true){
                        showError("Error connecting to database");
                    }

                    value.value = "";
                    description.value = "";
                    plotGraph();
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`type=updateProgress&data=${JSON.stringify(data)}`);
    }

}

document.getElementById("tp_add_new_submit").addEventListener("click",updateNewProgress);


let dots = [];

function plotGraph(){
    dots.forEach(elem => {
        chartArea.removeChild(elem);
    });
    dots.length = 0;

    let value = document.getElementById("current_progress").value;
    let colors = ['hsl(199,78%,51%)','hsl(159,84%,47%)','hsl(283,79%,59%)','hsl(159,88%,42%)','hsl(163,82%,41%)','hsl(154,85%,40%)','hsl(45,85%,43%)','hsl(78,80%,50%)'];

    let xhr = new XMLHttpRequest();
    document.getElementById("loading_screen").style.display = "block";
    xhr.open("POST", "server/router.php", true);
    xhr.onprogress = () => {
        document.getElementById("loading_bar").style.width = `${(xhr.readyState/xhr.DONE)*100}%`;
    }
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                document.getElementById("loading_bar").style.width = "100%";
                document.getElementById("loading_screen").style.display = "none";
                document.getElementById("tp_ent_val_bc").style.display = "none";

                progressChartCtx.clearRect(0,0,canvas.width,canvas.height);
                console.log(data);

                try {
                    data = JSON.parse(data);
                    const heightRatio = canvas.height/data['max_value'];
                    const widthRatio = canvas.width/10;
                    const values = data['data'];

                    if(values.length > 1){
                        let initialX = 0;
                        console.log(heightRatio);

                        for(let i = 1;i < values.length;i++){
                            let initialY = values[i-1]["value"]*heightRatio, finalY = values[i]["value"]*heightRatio;
                            progressChartCtx.beginPath();
                            progressChartCtx.moveTo(initialX, initialY);
                            initialX += widthRatio;
                            progressChartCtx.lineTo(initialX, finalY);
                            progressChartCtx.stroke();

                            let elem = document.createElement("div");
                            let bgColor = colors[Math.floor(Math.random() * colors.length)];
                            elem.classList.add("pt_points");
                            elem.style.top = `${chartArea.clientHeight - Math.floor(finalY-5) - 10}px`;
                            elem.style.left = `${Math.floor(initialX-5)}px`;
                            elem.style.backgroundColor = bgColor;
                            elem.title = `${values[i]["value"]} - ${values[i]["description"]} at ${values[i]["date"]}`;

                            let placcard = document.createElement("div");
                            placcard.classList.add("placcard","pt_points_placcard","flex-row", "align-center");
                            placcard.style.backgroundColor = bgColor;
                            placcard.innerText = values[i]["value"];

                            elem.appendChild(placcard);
                            chartArea.appendChild(elem);      
                            dots.push(elem);              

                        }
                    }
                } catch (error) {
                    showError("Error connecting to database.");
                }
                
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(`type=getProgress&data=${value}`);
}


document.getElementById("current_progress").addEventListener("input", plotGraph);



plotGraph();
document.getElementById("refresh-graph-btn").addEventListener("click",plotGraph);