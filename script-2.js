export class request{
    constructor(method,url,async){
        this.xhr = new XMLHttpRequest();
        this.data = "";
        this.xhr.open(method, url, async);
        this.xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        this.onload = function(){
            if(this.xhr.readyState === XMLHttpRequest.DONE){
                if(this.xhr.status === 200){
                    this.data = this.xhr.response;
                }
            }
        };
        this.xhr.onload = this.onload;
    }

    send(string){
        this.xhr.send(string);
    }
}