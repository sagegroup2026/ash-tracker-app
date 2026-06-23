document.addEventListener("DOMContentLoaded", function () {

    if (!navigator.geolocation) {
        setFallbackLocation();
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function (position) {

            const locationObj = {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                source: "gps"
            };

            document.getElementById("location").value =
                JSON.stringify(locationObj);

            console.log("GPS location set", locationObj);

        },
        function (error) {
            console.warn("GPS failed, using fallback", error);
            setFallbackLocation();
        },
        {
            enableHighAccuracy: false, // 🔥 IMPORTANT
            timeout: 15000,
            maximumAge: 60000
        }
    );
});

function setFallbackLocation() {

    // fallback when GPS fails
    const fallback = {
        latitude: null,
        longitude: null,
        source: "unavailable"
    };

    document.getElementById("location").value =
        JSON.stringify(fallback);

    console.log("Fallback location set");
}


// let locationFetched = false;

// document.addEventListener("DOMContentLoaded", function () {
//     fetchLocation();
// });

// function fetchLocation() {
//     if (!navigator.geolocation) {
//         console.warn("Geolocation not supported");
//         return;
//     }

//     navigator.geolocation.getCurrentPosition(
//         function (position) {

//             let locationObj = {
//                 latitude: position.coords.latitude,
//                 longitude: position.coords.longitude,
//                 accuracy: position.coords.accuracy
//             };

//             document.getElementById("location").value =
//                 JSON.stringify(locationObj);

//             locationFetched = true;
//             console.log("Location fetched", locationObj);
//         },
//         function (error) {
//             console.error("Location error", error);
//         },
//         {
//             enableHighAccuracy: true,
//             timeout: 10000
//         }
//     );
// }

// // 🚨 STOP submit if location not ready
// document.getElementById("visitForm").addEventListener("submit", function (e) {

//     if (!locationFetched) {
//         e.preventDefault();
//         alert("Fetching location, please wait...");
//         return false;
//     }
// });

