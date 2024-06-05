let navbar = document.getElementById("navbar");

export let colors = ['hsl(199,78%,51%)','hsl(159,84%,47%)','hsl(283,79%,59%)','hsl(159,88%,42%)'];

document.querySelectorAll(".home_tracker_snippet, .ai_placcard").forEach(element => {
    element.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
});


export function useToggle(button,closeBtn,div){
    button.addEventListener("click",() => {
        div.style.display = "block";
    });
    closeBtn.addEventListener("click",() => {
        div.style.display = "none";
    });
}

export function showError(err){
    document.getElementById("main_error_div").style.display = "block";
    document.getElementById("error_div_text").innerHTML = err;
}


export function addTypingAnimation(element){
    let div = document.createElement("div");
    div.classList.add("typing-indicator");
    for (let i = 0; i < 3; i++) {
        let dot = document.createElement("div");
        dot.classList.add("typing-dot");
        div.appendChild(dot);
    }
    element.appendChild(div);
}

export function showNotif(icon, text){
    document.getElementById("popup_notif_div").classList.add("show_popup_notif");
    document.getElementById("notif_icon").classList.add(...icon);
    document.getElementById("popup_notif_text").innerText = text;
    let sound = new Audio('media/notif.wav');
    sound.play();

    setTimeout(() => {
        document.getElementById("popup_notif_div").classList.remove("show_popup_notif");
    }, 4000);
}
