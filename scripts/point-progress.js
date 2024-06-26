fetch('get-mata-pengguna.php')
    .then(response => response.json())
    .then(data => {
        console.log(data);
        let userPoints = data.mata;
        updateProgressBar(userPoints);
    });

let currentPoints;
let maxPointsAllowed = 1000;

function updateProgressBar(points) {

    currentPoints = points;

    var bar = new ProgressBar.Circle("#view-mata", {
        strokeWidth: 6,
        easing: 'easeInOut',
        duration: 1000,
        color: '#009578',
        trailColor: '#adadad',
        trailWidth: 6,
        svgStyle: null,
        strokeLinecap: 'round'
    });


    bar.setText(currentPoints+"\nmata");
    bar.text.style.fontSize = "4rem";
    bar.animate((currentPoints/maxPointsAllowed));
}