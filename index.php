<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deteksi Orang dengan Kamera</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/coco-ssd"></script>
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    text-align: center;
    position: relative;
}

#video {
    border: 2px solid #333;
}

.alert {
    margin-top: 20px;
    padding: 10px;
    background-color: rgba(255, 0, 0, 0.6);
    color: white;
    font-weight: bold;
    display: inline-block;
    border-radius: 5px;
}

.hidden {
    display: none;
}

</style>
<body>
    <div class="container">
        <h1>Deteksi Orang Menggunakan Kamera</h1>
        <video id="video" width="640" height="480" autoplay></video>
        <div id="alert" class="alert hidden">Orang Terdeteksi!</div>
    </div>

    <script>
        async function setupCamera() {
            const video = document.getElementById('video');
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        }

        async function detectObjects() {
            const model = await cocoSsd.load();
            const video = document.getElementById('video');
            
            const predictions = await model.detect(video);
            
            let detected = false;

            predictions.forEach(prediction => {
                if (prediction.class === 'person') {
                    detected = true;
                }
            });

            const alertBox = document.getElementById('alert');
            if (detected) {
                alertBox.classList.remove('hidden');
            } else {
                alertBox.classList.add('hidden');
            }
        }

        setupCamera();
        setInterval(detectObjects, 1000);  // Deteksi setiap detik
    </script>
    <script>
        async function saveDetection(result) {
    const response = await fetch('detect.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ result: result })
    });

    const data = await response.json();
    console.log(data);
}

async function detectObjects() {
    const model = await cocoSsd.load();
    const video = document.getElementById('video');
    const predictions = await model.detect(video);
    
    let detected = false;

    predictions.forEach(prediction => {
        if (prediction.class === 'person') {
            detected = true;
        }
    });

    const alertBox = document.getElementById('alert');
    if (detected) {
        alertBox.classList.remove('hidden');
        saveDetection('Orang Terdeteksi');
    } else {
        alertBox.classList.add('hidden');
        saveDetection('Tidak Ada Orang');
    }
}

    </script>
    
</body>
</html>

