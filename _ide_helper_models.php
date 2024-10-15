<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $ID
 * @property int $country_id
 * @property string|null $label
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property int $is_active
 * @property int $last_enrollment_count
 * @property int $last_invoice_count
 * @property int $last_payment_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $last_admission_count
 * @property string|null $admission_prefix
 * @property int|null $admission_base
 * @property int|null $admission_padding
 * @property int $last_certificate_count
 * @property string|null $enrollment_prefix
 * @property int|null $enrollment_base
 * @property int|null $enrollment_padding
 * @method static \Illuminate\Database\Eloquent\Builder|Centre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Centre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Centre query()
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereAdmissionBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereAdmissionPadding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereAdmissionPrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereEnrollmentBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereEnrollmentPadding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereEnrollmentPrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereLastAdmissionCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereLastCertificateCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereLastEnrollmentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereLastInvoiceCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereLastPaymentCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Centre whereUpdatedAt($value)
 */
	class Centre extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $section_id
 * @property string $menu_icon
 * @property string $menu_label
 * @property string|null $menu_route
 * @property int|null $menu_rank
 * @property int $menu_status
 * @property string $permission_name
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMenuIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMenuLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMenuRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMenuRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMenuStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu wherePermissionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 */
	class Menu extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property string $guard_name
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RoleHasPermissions> $role_has_permissions
 * @property-read int|null $role_has_permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $display_name
 * @property int $role_group_id
 * @property string $permission
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserHasRoles> $user_has_role
 * @property-read int|null $user_has_role_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role wherePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereRoleGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $permission_id permissions
 * @property int $role_id roles
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Permission $permission
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions query()
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RoleHasPermissions whereUpdatedAt($value)
 */
	class RoleHasPermissions extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $ID
 * @property string $user_login
 * @property string $user_pass
 * @property string $user_nicename
 * @property string $user_email
 * @property int|null $user_country_id
 * @property string|null $user_state
 * @property string|null $user_address
 * @property string|null $user_contact
 * @property string|null $user_photo
 * @property string $user_url
 * @property string $user_registered
 * @property string $user_activation_key
 * @property int $user_status
 * @property string $display_name
 * @property int $spam
 * @property int $deleted
 * @property string|null $remember_token
 * @property int|null $first_time_login
 * @property int|null $profile_updated
 * @property int|null $is_admin
 * @property int|null $can_view_all_centres
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserHasRoles> $user_has_role
 * @property-read int|null $user_has_role_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCanViewAllCentres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstTimeLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfileUpdated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSpam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserActivationKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserNicename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserPass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserUrl($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id wpvt_users
 * @property int $role_id roles
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Role|null $role
 * @property-read \Corcel\Model\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserHasRoles newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserHasRoles newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserHasRoles query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserHasRoles whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserHasRoles whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserHasRoles whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserHasRoles whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserHasRoles whereUserId($value)
 */
	class UserHasRoles extends \Eloquent {}
}

