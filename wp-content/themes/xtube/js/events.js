
function ajax_post(url, data) {
    jQuery.ajax({
        type: "post",
        url: url,
        data: data,
        error: function (response) {
            console.log(response);
        },
        success: function (response) {
            // Actualiza el mensaje con la respuesta
            console.log('success:: ' + response);
        }
    });
}

function report() {
    var video_id = document.vote_form.elements['video_id'].value;
    var reason = document.report_form.elements['reason'].value;

    var data = {
        "video_id": video_id,
        "reason": reason,
        "url": ajax_var.url,
        "action": "video_report",
        "nonce": ajax_var.nonce
    }
    ajax_post(ajax_var.url, data);
}

function vote(v) {
    var video_id = document.vote_form.elements['video_id'].value;
    var data = {
        "vote": v,
        "video_id": video_id,
        "url": ajax_var.url,
        "action": ajax_var.action,
        "nonce": ajax_var.nonce
    }

    jQuery.ajax({
        type: "post",
        url: ajax_var.url,
        data: data,
        error: function (response) {
            console.log(response);
        },
        success: function (response) {
            // Actualiza el mensaje con la respuesta
            console.log('success:: ' + response);
        }
    });
    /*
     var url = 'action=' + ajax_var.action + '&nonce=' + ajax_var.nonce;
     url += '&vote=' + video_id + '&vote=' + vote;
 
     fetch(ajax_var.url, {
         method: "POST",
         credentials: 'same-origin',
         headers: { 'Content-type': 'application/x-www-form-urlencoded' },
         body: url
     });*/
}