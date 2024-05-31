
let navbar = document.getElementById("navbar");

export let colors = ['hsl(199,78%,51%)','hsl(159,84%,47%)','hsl(283,79%,59%)','hsl(159,88%,42%)'];

document.querySelectorAll(".home_tracker_snippet").forEach(element => {
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


