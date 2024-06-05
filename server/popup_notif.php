<div class="popup_notif_div flex-row align-center placcard" id = "popup_notif_div">
    <i class="fa" id = "notif_icon"></i>
    <div class="popup_notif_text" id="popup_notif_text">
        You are now connected.
    </div>
    <button class="tp_add_new_close_btn ml-10" style = "margin-right: 0px;"><i class="fa fa-close"></i></button>
</div>

<style>
    .popup_notif_div{
        position: fixed;
        bottom: 10px;
        left: 10px;
        background: #f1f1f1;
        width: fit-content;
        height: 50px;
        padding: 10px;
        border-radius: 16px;
        z-index: 999999;
        transform: translateY(250%);
        transition: 1.2s;
    }
    .popup_notif_text{
        color: var(--grey);
        font-size: var(--font-size);
    }
    .connected_icon{
        margin: 0px 10px 0px 0px;
        font-size: 25px;
        color: var(--primary-color);
    }
    .error{
        color: var(--red);
        margin: 0px 10px 0px 0px;
        font-size: 25px;
    }
    .show_popup_notif{
        transform: translateY(0px);
    }
</style>