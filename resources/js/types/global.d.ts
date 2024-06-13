import { AxiosInstance } from 'axios';
import { route as ziggyRoute } from 'ziggy-js';
import Echo from "laravel-echo";
import Pusher from "pusher-js";

declare global {
    interface Window {
        axios: AxiosInstance;
        Pusher: any;
        Echo: Echo;
    }

    var route: typeof ziggyRoute;
}
