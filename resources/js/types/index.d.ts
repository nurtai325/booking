export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};

interface Reservation {
    record_id: number;
    name: string;
    phone: string;
    additional_info: string | null;
    booking_id: number;
    client_has_come: number;
    canceled: number;
    created_at: string;
    updated_at: string;
}

interface Booking {
    booking_id: number;
    service_id: number;
    start_time: string;
    created_at: string;
    updated_at: string;
    records: Reservation[];
}

interface Service {
    service_id: number;
    user_id: number;
    name: string;
    description: string;
    price: number;
    capacity: number;
    created_at: string;
    updated_at: string;
    additional_info: string | null;
    duration: number;
}

interface BookingDetail {
    booking: Booking;
    records: Reservation[];
}

interface ServiceDetail {
    service: Service;
    bookings: BookingDetail[];
}

interface Event {
    reservation: Reservation;
}
