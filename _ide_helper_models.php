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
 * Class Company
 *
 * @package App\Models
 * @property int $id
 * @property string $tax_id
 * @property string $title
 * @property string|null $short_title
 * @property string $address
 * @property int $last_invoice_number
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereLastInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereShortTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedAt($value)
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Invoice
 *
 * @package App\Models
 * @property int $id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property App\Types\InvoiceType $type
 * @property App\Types\InvoiceStatus $status
 * @property DateTime $action_date
 * @property DateTime $creation_date
 * @property string $number
 * @property float $total
 * @property float $total_vat
 * @property float $total_wo_vat
 * @property int|null $signatory
 * @property int $recipient_company
 * @property int $author
 * @property int $sender_company
 * @property array $delivery_documents
 * @property DateTime $contract_date
 * @property string $contract_number
 * @property string|null $parent_invoice_id
 * @property int $sender_company_id
 * @property int $author_id
 * @property int $recipient_company_id
 * @property int|null $signatory_id
 * @property mixed|null $invoice_items
 * @property-read Invoice|null $parent_invoice
 * @method static \Database\Factories\InvoiceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice filter(\App\Filters\FilterInterface $filter)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereActionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereContractDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereContractNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereCreationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDeliveryDocuments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereInvoiceItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereParentInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereRecipientCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereSenderCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereSignatoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereTotalVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereTotalWoVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereUpdatedAt($value)
 */
	class Invoice extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $role
 * @property int|null $company_id
 * @property-read \App\Models\Company|null $company
 * @property-read string $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

