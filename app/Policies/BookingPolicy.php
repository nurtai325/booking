<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Booking $booking): bool
    {
        $services = $user->services;

        foreach ($services as $service) {
            if ($service->getKey() === $booking->service_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, int $service_id): bool
    {
        $services = $user->services;

        foreach ($services as $service) {
            if ($service->getKey() === $service_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Booking $booking): bool
    {
        $services = $user->services;

        foreach ($services as $service) {
            if ($service->getKey() === $booking->service_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Booking $booking): bool
    {
        $services = $user->services;

        foreach ($services as $service) {
            if ($service->getKey() === $booking->service_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Booking $booking): bool
    {
        $services = $user->services;

        foreach ($services as $service) {
            if ($service->getKey() === $booking->service_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Booking $booking): bool
    {
        $services = $user->services;

        foreach ($services as $service) {
            if ($service->getKey() === $booking->service_id) {
                return true;
            }
        }

        return false;
    }
}
