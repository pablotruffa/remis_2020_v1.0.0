<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\CancellationReason
 *
 * @property int $id
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason whereUpdatedAt($value)
 */
	class CancellationReason extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CarBrand
 *
 * @property int $id
 * @property string $brand
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand whereUpdatedAt($value)
 */
	class CarBrand extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CarColor
 *
 * @property int $id
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor whereUpdatedAt($value)
 */
	class CarColor extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Client
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $identification_card_number
 * @property string $date_of_birth
 * @property string|null $picture
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereIdentificationCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client withoutTrashed()
 */
	class Client extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Driver
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $identification_card_number
 * @property string $car_license
 * @property int|null $assigned_vehicle
 * @property string $date_of_birth
 * @property string|null $picture
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \App\Models\Presenteeism $presenteeism
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reservation[] $reservation
 * @property-read int|null $reservation_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Driver onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereAssignedVehicle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereCarLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereIdentificationCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver wherePresenteeism($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Driver withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Driver withoutTrashed()
 */
	class Driver extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Presenteeism
 *
 * @property int $id
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism whereUpdatedAt($value)
 */
	class Presenteeism extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RemisUserLevel
 *
 * @property int $id
 * @property string $level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RemisUsers $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel whereUpdatedAt($value)
 */
	class RemisUserLevel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RemisUsers
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property int|null $level_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RemisUserLevel|null $level
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RemisUsers onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RemisUsers withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RemisUsers withoutTrashed()
 */
	class RemisUsers extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Reservation
 *
 * @property int $id
 * @property int $confirmation_number
 * @property string $travel_date
 * @property string $travel_time
 * @property string $origin
 * @property string $destiny
 * @property int $vehicle_quantity
 * @property float $price
 * @property float $commission_percentage
 * @property int $reservation_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CancellationReason[] $cancellation
 * @property-read int|null $cancellation_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[] $client
 * @property-read int|null $client_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Driver[] $driver
 * @property-read int|null $driver_count
 * @property-read \App\Models\ReservationLog|null $log
 * @property-read \App\Models\ReservationStatus $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereCommissionPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereConfirmationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereDestiny($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereReservationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereTravelDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereTravelTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereVehicleQuantity($value)
 */
	class Reservation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReservationLog
 *
 * @property int $id
 * @property int $confirmation_number
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog whereConfirmationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog whereUpdatedAt($value)
 */
	class ReservationLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReservationStatus
 *
 * @property int $id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus whereUpdatedAt($value)
 */
	class ReservationStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Vehicle
 *
 * @property int $id
 * @property string $patent
 * @property string $model
 * @property string $year
 * @property string|null $picture
 * @property int $id_brand
 * @property int $id_color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CarBrand $brand
 * @property-read \App\Models\CarColor $color
 * @property-read \App\Models\Driver|null $driver
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vehicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vehicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vehicle query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vehicle whereIdBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vehicle whereIdColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vehicle whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vehicle wherePatent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vehicle wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vehicle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vehicle whereYear($value)
 */
	class Vehicle extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

