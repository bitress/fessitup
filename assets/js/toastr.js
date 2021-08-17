function showSuccessToasts(message, title = "Success!", hideafter = 2000) {
    $.toast({
        heading: title,
        text: message,
        icon: 'success',
        showHideTransition: 'slide', // fade, slide or plain
        allowToastClose: false, // Boolean value true or false
        hideAfter: hideafter, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
        stack: false, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
        position: 'top-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
        
    });
}

function showErrorToasts(message, title = "Oopsie!", hideafter = 2000) {
    $.toast({
        heading: title,
        text: message,
        icon: 'error',
        showHideTransition: 'slide', // fade, slide or plain
        allowToastClose: false, // Boolean value true or false
        hideAfter: hideafter, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
        stack: false, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
        position: 'top-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
        
    });
}

function showInfoToasts(message, title = "Info!", hideafter = 2000) {
    $.toast({
        heading: title,
        text: message,
        icon: 'info',
        showHideTransition: 'slide', // fade, slide or plain
        allowToastClose: false, // Boolean value true or false
        hideAfter: hideafter, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
        stack: false, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
        position: 'top-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values
        
    });  
}