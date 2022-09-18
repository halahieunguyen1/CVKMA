<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait PersonTrait
{
    protected ?string $firstName = null;
    protected ?string $lastName = null;

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string|null
     */
    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: fn () =>  $this->first_name . ' ' . $this->last_name,
        );
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) =>  bcrypt($value),
        );
    }
}
