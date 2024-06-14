import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import {PageProps, Event, Reservation} from '@/types';
import {useEffect, useState} from "react";
import TimeTable from "@/Components/Dashboard/TimeTable";
import {useStore} from "@/store";
import axios from "axios";
import Echo from "laravel-echo";
import Pusher from "pusher-js";

export default function Dashboard({ auth }: PageProps) {
    const kz = useStore((state) => state.kz);
    const [loaded, setLoaded] = useState(false);
    const [schedule, setSchedule ] = useState([]);

    auth.user.id;

    useEffect(() => {
        axios.get("http://localhost/api/schedule?id=1")
            .then((response) => {
                 setSchedule(response.data.data);
                 setLoaded(true);
            })
            .catch((error) => console.log(error.message));
    }, []);

    window.Pusher = Pusher;

    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST,
        wsPort: import.meta.env.VITE_REVERB_PORT,
        wssPort: import.meta.env.VITE_REVERB_PORT,
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
        enabledTransports: ['ws', 'wss'],
    });

    window.Echo.private(`bookings.${auth.user.id}`)
        .listen('BookingReceived', (e: Event) => {
            console.log(e.reservation);
        });


    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-black leading-tight">{kz ? " Кесте" : "Расписание"}</h2>}
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="w-auto mx-auto sm:px-6 lg:px-8">
                    <div className="dark:bg-none overflow-hidden shadow-sm sm:rounded-lg flex">
                        {loaded ? <TimeTable schedule={schedule}/> : <div>{kz ? " Кесте туралы ақпарат жүктелуде..." : "Данные расписания загружаются..."}</div>}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
