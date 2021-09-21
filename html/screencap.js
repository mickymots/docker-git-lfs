//const startElem = document.getElementById("start");
canvas = document.getElementById('photo') 

// helper function: generate a new file from base64 String
function dataURLtoFile(dataurl, filename){
    const arr = dataurl.split(',')
    const mime = arr[0].match(/:(.*?);/)[1]
    const bstr = atob(arr[1])
    let n = bstr.length
    const u8arr = new Uint8Array(n)
    while (n) {
        u8arr[n - 1] = bstr.charCodeAt(n - 1)
        n -= 1 // to make eslint happy
    }
    return new File([u8arr], filename, { type: mime })
}


function resolveBitMap(canvas) {
    return async function(bitmap){
        canvas.width = bitmap.width
        canvas.height = bitmap.height
        const context = canvas.getContext('2d')
        context.drawImage(bitmap, 0, 0, bitmap.width, bitmap.height)
        const image = canvas.toDataURL()
        console.log(image);
        return dataURLtoFile(image, 'photo.png')
    }
}


function uploadPhoto(file) {
    console.log('Uploading photo:', file);
    const formData = new FormData()
    formData.append('photo', file, file.name)
    // now upload
    const config = {headers: { 'Content-Type': 'multipart/form-data' }}

    var request = new XMLHttpRequest();
    request.open("POST", "http://localhost:5000/file_upload");
    request.send(formData);

}
/*
// Set event listeners for the start and stop buttons
startElem.addEventListener("click", function (evt) {
    resolveBitMapFn = resolveBitMap(canvas)
    startCapture().then(resolveBitMapFn).then(uploadPhoto).catch(function(err){
        console.log(err);
    })
})
*/

function delayedCapture(captureStream) {
    return new Promise((resolve, reject)=>{
        setTimeout(() => {
            const track = captureStream.getVideoTracks()[0]
            resolve(track)
        }, 200);

    });
}


async function startCapture() {
    let bitmap = null;

    try {
        captureStream = await navigator.mediaDevices.getDisplayMedia({video:true, audio:false});
        const track = await delayedCapture(captureStream)
        console.log(track)
        const imageCapture = new ImageCapture(track)
        bitmap = await imageCapture.grabFrame()
        track.stop()
    } catch (err) {
        console.error("Error: " + err);
    }
    return bitmap;
}