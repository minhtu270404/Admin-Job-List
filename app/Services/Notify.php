<?php
namespace App\Services;


class Notify {

    // Created Notification
    static function createdNotification($message) {
        return notyf()->addSuccess($message, 'Success!');
    }

    // Updated Notification
    static function updatedNotification($message) {
        return notyf()->addSuccess($message, 'Success!');
    }

    // Deleted Notification
    static function deletedNotification($message) {
        return notyf()->addSuccess($message, 'Success!');
    }

    static function errorNotification(string $error) {
        return notyf()->addError($error, 'Error!');
    }

    static function successNotification(string $message) {
        return notyf()->addSuccess($message, 'Success!');
    }




}