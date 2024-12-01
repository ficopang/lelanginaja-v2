import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: "reverb",
//     broadcaster: "reverb",
//     key: import.meta.env.VITE_REVERB_APP_KEY,
//     wsHost: import.meta.env.VITE_REVERB_HOST,
//     wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
//     wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
//     enabledTransports: ["ws", "wss"],
// });

// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: "a6184cb9a0658463dc6f",
    cluster: "ap1",
    encrypted: true,
});
