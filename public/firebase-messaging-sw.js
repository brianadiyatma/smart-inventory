importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js");

firebase.initializeApp({
    apiKey: "AIzaSyA9vhAa9jqHxdze0lP59lR7PQde18HHxhk",
    authDomain: "laravelfcm-74fff.firebaseapp.com",
    projectId: "laravelfcm-74fff",
    storageBucket: "laravelfcm-74fff.appspot.com",
    messagingSenderId: "245859545840",
    appId: "1:245859545840:web:dbb68b5ec4d9ad67618835",
    measurementId: "G-CJ4E5P6737",
});
self.addEventListener("notificationclick", (event) => {
    console.log("On notification click: ", event.notification.tag);
    event.notification.close();

    // This looks to see if the current is already open and
    // focuses if it is
    event.waitUntil(
        clients
            .matchAll({
                type: "window",
            })
            .then((clientList) => {
                for (const client of clientList) {
                    if (client.url === "/" && "focus" in client)
                        return client.focus();
                }
                if (clients.openWindow) return clients.openWindow("/");
            })
    );
});
const messaging = firebase.messaging();
messaging.onBackgroundMessage(function (payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload
    );
    // Customize notification here
    const notificationTitle = payload.data.title;
    const notificationOptions = {
        body: payload.data.body,
        icon: payload.data.icon,
        image: payload.data.image,
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
