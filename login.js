
var welcome_words=[
    'Welcome to  story hub.<br>Story hub brings to you all of your favourite novels right to you.',
    'Story hub lets you share your thoughts about a story or a novel you like whilst following your favourite authors and also join group chats created by these authors.',
    'You yourself can also become an author by just setting up your authours account',
    'You are all set for the world of story hub, click next to proceed to create an account.'
];
var bg_image=['image-2.jpg','image-3.jpg','image-4.jpg','image-5.jpg'];
var current_position=0;
const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;          //initialise email pattern woth regex.
const stringPattern = /^[a-zA-Z\s]+$/;                              //initialize string with regex.




for(i=0;i<(welcome_words.length-1);i++){
    document.getElementById("pos_cont").innerHTML+="<div class=\"position\"></div>";
}
function fwd(){
    if(current_position<(welcome_words.length-1)){
        current_position++;
        if(welcome_words[current_position]!="undefined"){
            document.getElementById("display_text").innerHTML=welcome_words[current_position];
            document.getElementById("body").style.backgroundImage= "url('"+bg_image[current_position]+"')";
            if(current_position==(welcome_words.length-1)){
                document.getElementById("next").style.display="none";
                document.getElementById("proceed_btn").style.display="block";
            }
            if(current_position>0){
                document.getElementById("prev").style.display="block";
            }
        }
    }
    for(i=0;i<document.getElementsByClassName("position").length;i++){
        if(document.getElementsByClassName("position")[i].classList.contains("current")){
            document.getElementsByClassName("position")[i].classList.remove("current");
        }
    }
    document.getElementsByClassName("position")[current_position].classList.add("current");
}
function back(){
    if(current_position>0){
        current_position--;
        document.getElementById("display_text").innerHTML=welcome_words[current_position];
        document.getElementById("body").style.backgroundImage= "url('"+bg_image[current_position]+"')";
        if(current_position==0){
            document.getElementById("prev").style.display="none";
        }
        if(current_position<welcome_words.length){
            document.getElementById("next").style.display="block";
        }
        document.getElementById("proceed_btn").style.display="none";
        for(i=0;i<document.getElementsByClassName("position").length;i++){
            if(document.getElementsByClassName("position")[i].classList.contains("current")){
                document.getElementsByClassName("position")[i].classList.remove("current");
            }
        }
        document.getElementsByClassName("position")[current_position].classList.add("current");
    }
}
function proceed(){
    document.getElementById("preamble").style.display="none";
    document.getElementById("main").style.display="block";
}

function def(){
    document.querySelectorAll(".input_fields").forEach(element=>{
        element.classList.remove("error");
        element.classList.remove("error_line");
        element.value.length=0;
        element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-question-circle");
        element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-check-circle");
    });
}


function signIn(uname, pwd){
    let isError = false;

    


    if(!isError){
        document.getElementById("bc_loading").style.display="block";


        var formData = {
            "username": uname,
            "pwd": pwd
        }


        let xhr = new XMLHttpRequest();
        xhr.open("POST", "server/router.php", true);
        xhr.onprogress = () => {
            document.getElementById("loading_bar").style.width = `${(xhr.readyState/xhr.DONE)*100}%`;
        }
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    console.log(data);
                    document.getElementById("bc_loading").style.display="none";
                    
                    try {
                        JSON.parse(data);

                        data = JSON.parse(data);
                        if(data.success == true){
                            window.location.href = `index.php?u=${data.uname}`;
                        }
                        else{
                            showError('Error processing data.')
                        }

                    } catch (error) {
                        showError(data);
                    }
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`type=login&data=${JSON.stringify(formData)}`);
    }

}
document.getElementById("prev").addEventListener("click",back);
document.getElementById("next").addEventListener("click",fwd);
document.getElementById("proceed_btn").addEventListener("click",proceed);
document.getElementById("login_link").addEventListener("click",()=>{
    document.getElementById("main").style.display="none";
    document.getElementById("main_login").style.display="block";
    def();
});
document.getElementById("signup_link").addEventListener("click",()=>{
    document.getElementById("main_login").style.display="none";
    document.getElementById("main").style.display="block";
    def();
});

document.getElementById("submit_btn").addEventListener("click",()=>{
    var isError=false;
     document.querySelectorAll(".input_fields, .dob_input, .opt_menu").forEach(element=>{
        if(element.id=="gender" && element.value.length<1){
            element.classList.add("error");
            element.classList.add("error_line");
            isError=true;
            setTimeout(() => {
                element.classList.remove("error");
            }, 1500);
        }
        if(element.value.length<1 && (!(element.id=="uname_login"))&& (!(element.id=="pwd_login"))){
            element.classList.add("error");
            element.classList.add("error_line");
            isError=true;
            setTimeout(() => {
                element.classList.remove("error");
            }, 1500);
            element.addEventListener("input",()=>{
                if(element.value.length>1){
                    element.classList.remove("error_line");
                    element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-question-circle");
                    element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-check-circle");
                }
                else{
                    element.classList.add("error_line");
                    element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-question-circle");
                    element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-check-circle");
                }
            });
        }
        if(element.id=="uname" && element.value.includes(" ")){
            document.getElementById("uname_err").innerText="Username cannot contain spaces";
            element.classList.add("error");
            element.classList.add("error_line");
            isError=true;
            setTimeout(() => {
                element.classList.remove("error");
            }, 1500);
            element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-question-circle");
            element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-check-circle");
        }
        var passwordsDoNotMatch= false;
        if((document.getElementById("pwd").value.length)>0 && (document.getElementById("pwd_repeat").value.length>0)){
            if(document.getElementById("pwd").value != document.getElementById("pwd_repeat").value){
                isError=true;
                passwordsDoNotMatch=true;
                document.getElementById("pwd_err").innerText="Paswords Do not Match";
            }
            if(passwordsDoNotMatch){
                document.querySelectorAll("#pwd,#pwd_repeat").forEach(pd_element=>{
                    pd_element.classList.add("error");
                    pd_element.classList.add("error_line");
                    isError=true;
                    setTimeout(() => {
                        pd_element.classList.remove("error");
                    }, 1500);
                    pd_element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-question-circle");
                    pd_element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-check-circle");
                });
                document.querySelectorAll("#pwd,#pwd_repeat").forEach(ells=>{
                    ells.addEventListener("input",()=>{
                        if(document.getElementById("pwd").value != document.getElementById("pwd_repeat").value){
                            isError=true;
                            passwordsDoNotMatch=true;
                            document.getElementById("pwd_err").innerText="Paswords Do not Match";
                            document.querySelectorAll("#pwd,#pwd_repeat").forEach(x => {
                                x.classList.add("error");
                                x.classList.add("error_line");
                                isError=true;
                                setTimeout(() => {
                                    x.classList.remove("error");
                                }, 1500);
                                x.parentElement.getElementsByClassName("fa")[0].classList.add("fa-question-circle");
                                x.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-check-circle");
                            });
                        }
                        else{
                            document.getElementById("pwd_err").innerText="";
                            document.querySelectorAll("#pwd,#pwd_repeat").forEach(x=>{
                                x.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-question-circle");
                                x.parentElement.getElementsByClassName("fa")[0].classList.add("fa-check-circle");
                            });
                        }
                    });
                });
            }
        }
        if(element.id == "email"){
            if((!(emailPattern.test(element.value)))){
                document.getElementById("email_err").innerText="Please enter a valid email";
                element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-question-circle");
                element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-check-circle");
            }
        }
        if(element.id == "name"){
            if((!(stringPattern.test(element.value)))){
                document.getElementById("name_err").innerText="Name can only contain letters";
                element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-question-circle");
                element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-check-circle");
            }
        }
     });
     if(document.getElementById("pwd").value.length<4 || document.getElementById("pwd_repeat").value.length<4){
        isError=true;
     }
     if(!(document.getElementById("accept_terms").checked)){
        document.getElementById("accept_terms_text").classList.add("check_err");
        setTimeout(() => {
            document.getElementById("accept_terms_text").classList.remove("check_err");
        }, 1500);
        isError=true;
     }
    if(!(isError)){
        document.getElementById("bc_loading").style.display="block";
        var name= document.getElementById("name").value;
        var uname= document.getElementById("uname").value;
        var email= document.getElementById("email").value;
        var gender= document.getElementById("gender").value;
        var pwd= document.getElementById("pwd").value;
        var dob= document.getElementById("dob").value;
        
        let formData = {};
        formData['name'] = name;
        formData['uname'] = uname;
        formData['email'] = email;
        formData['gender'] = gender;
        formData['pwd'] = pwd;
        formData['dob'] = dob;

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "server/router.php", true);
        xhr.onprogress = () => {
            document.getElementById("loading_bar").style.width = `${(xhr.readyState/xhr.DONE)*100}%`;
        }
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    try {
                        JSON.parse(data);
                        signIn(uname, pwd)
                    } catch (error) {

                        showError(data);
                    }
                }
            }
        }
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(`type=register_user&data=${JSON.stringify(formData)}`);
    }
});


document.querySelectorAll(".input_fields").forEach(element=>{
    element.addEventListener("input",()=>{

        if(element.id!="pwd_repeat" || element.id!="pwd"){
            if(element.value.length>1 && (!(element.classList.contains("dob_input")))){
                element.classList.remove("error_line");
                element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-question-circle");
                element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-check-circle");
            }
            else{
                element.classList.add("error_line");
                element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-question-circle");
                element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-check-circle");
            }
            if(element.id=="uname"){
                if(element.value.includes(" ")){
                    document.getElementById("uname_err").innerText="Username cannot contain space"
                    element.classList.add("error");
                    element.classList.add("error_line");
                    setTimeout(() => {
                        element.classList.remove("error");
                    }, 1500);
                    element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-question-circle");
                    element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-check-circle");
                }
                else{
                    document.getElementById("uname_err").innerText="";
                    element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-question-circle");
                    element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-check-circle");
                }
            }
            if(element.id == "email"){
                if((!(emailPattern.test(element.value)))){
                    document.getElementById("email_err").innerText="Please enter a valid email";
                    element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-question-circle");
                    element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-check-circle");
                }
                else{
                    document.getElementById("email_err").innerText="";
                    element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-question-circle");
                    element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-check-circle");
                }
            }
            if(element.id == "name"){
                if((!(stringPattern.test(element.value)))){
                    document.getElementById("name_err").innerText="Name can only contain letters";
                    element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-question-circle");
                    element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-check-circle");
                }
                else{
                    document.getElementById("name_err").innerText="";
                    element.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-question-circle");
                    element.parentElement.getElementsByClassName("fa")[0].classList.add("fa-check-circle");
                }
            }
        }
    });
});


document.querySelectorAll("#pwd,#pwd_repeat").forEach(ells=>{
    ells.addEventListener("blur",()=>{
        if((document.getElementById("pwd").value != document.getElementById("pwd_repeat").value) && (document.getElementById("pwd").value.length>0 && document.getElementById("pwd_repeat").value.length>0)){
            isError=true;
            passwordsDoNotMatch=true;
            document.getElementById("pwd_err").innerText="Paswords Do not Match";
            document.querySelectorAll("#pwd,#pwd_repeat").forEach(x => {
                x.classList.add("error");
                x.classList.add("error_line");
                isError=true;
                setTimeout(() => {
                    x.classList.remove("error");
                }, 1500);
                x.parentElement.getElementsByClassName("fa")[0].classList.add("fa-question-circle");
                x.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-check-circle");
            });
        }
        else{
            if((document.getElementById("pwd").value.length<4 && document.getElementById("pwd_repeat").value.length<4)){
                document.getElementById("pwd_err").innerText="Paswords should have at least 4 characters";
                document.querySelectorAll("#pwd,#pwd_repeat").forEach(x => {
                    x.classList.add("error_line");
                    x.parentElement.getElementsByClassName("fa")[0].classList.add("fa-question-circle");
                    x.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-check-circle");
                });
            }else{
                document.getElementById("pwd_err").innerText="";
                document.querySelectorAll("#pwd,#pwd_repeat").forEach(x=>{
                    x.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-question-circle");
                    x.parentElement.getElementsByClassName("fa")[0].classList.add("fa-check-circle");
                    x.classList.remove("error_line");
                });
            }
            
        }
    });
});


document.querySelectorAll("#pwd,#pwd_repeat").forEach(ells=>{
    ells.addEventListener("input",()=>{
        if((document.getElementById("pwd").value != document.getElementById("pwd_repeat").value) && (document.getElementById("pwd").value.length>0 && document.getElementById("pwd_repeat").value.length>0)){
            document.getElementById("pwd_err").innerText="Paswords Do not Match";
            document.querySelectorAll("#pwd,#pwd_repeat").forEach(x => {
                x.classList.add("error_line");
                x.parentElement.getElementsByClassName("fa")[0].classList.add("fa-question-circle");
                x.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-check-circle");
            });
        }
        else{
            document.getElementById("pwd_err").innerText="";
            document.querySelectorAll("#pwd,#pwd_repeat").forEach(x=>{
                x.parentElement.getElementsByClassName("fa")[0].classList.remove("fa-question-circle");
                x.parentElement.getElementsByClassName("fa")[0].classList.add("fa-check-circle");
                x.classList.remove("error_line");
            });
        }
    });
});

document.getElementById("gender").addEventListener("input",()=>{
    if(document.getElementById("gender").value.length>1){
        document.getElementById("gender").parentElement.getElementsByClassName("fa")[0].classList.remove("fa-question-circle");
        document.getElementById("gender").parentElement.getElementsByClassName("fa")[0].classList.add("fa-check-circle");
        document.getElementById("gender").classList.remove("error_line");
    }
    else{
        document.getElementById("gender").parentElement.getElementsByClassName("fa")[0].classList.add("fa-question-circle");
        document.getElementById("gender").parentElement.getElementsByClassName("fa")[0].classList.remove("fa-check-circle");
        document.getElementById("gender").classList.add("error_line");
    }
});

document.getElementById("login_btn").addEventListener("click",()=>{
    let isError = false;
    var uname= document.getElementById("uname_login");
    var pwd= document.getElementById("pwd_login");

    let elements = [uname, pwd];

    elements.forEach(element => {
        if(element.value.length < 1){
            element.classList.add("error");
            element.classList.add("error_line");
            isError = true;
            setTimeout(() => {
                element.classList.remove("error");
            }, 1500);
        }
    });

    if(!isError){
        signIn(uname.value, pwd.value);
    }
});

document.getElementById("gender").value="";


function showError(error) {
    document.getElementById("error_text").innerText = error;
    document.getElementById("error_bc").style.display = "block";
}

document.getElementById("error_btn").addEventListener("click",() => {
    document.getElementById("error_bc").style.display = "none";
    document.getElementById("bc_loading").style.display="none";
});