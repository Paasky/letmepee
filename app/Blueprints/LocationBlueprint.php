<?php /** @noinspection PhpUnused */

namespace App\Blueprints;

use app\Exceptions\InvalidArgumentsException;
use App\Models\Common\LmpModel;
use App\Models\Location;
use App\User;
use app\Validators\PointValidator;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class LocationBlueprint implements Blueprint
{
    protected Point $coords;
    protected string $name;
    protected string $type;
    protected string $status = Location::STATUS_UNVERIFIED;
    protected string $description;
    protected User $user;

    public function __construct(Point $coords, string $name, string $type, string $description, User $user)
    {
        $this->coords = $coords;
        $this->name = $name;
        $this->type = $type;
        $this->description = $description;
        $this->user = $user;
    }

    /**
     * @param Location|LmpModel $model
     * @return static
     */
    public static function fromModel(LmpModel $model): self
    {
        return (new static(
            $model->coords,
            $model->name,
            $model->type,
            $model->description,
            $model->user
        ))->setStatus($model->status);
    }

    /**
     * @inheritDoc
     */
    public function isValid(bool $verify = false): bool
    {
        $errors = [];

        try {
            PointValidator::isValid($this->coords, true);
        } catch (\InvalidArgumentException $e) {
            $errors[] = "Invalid coords: {$e->getMessage()}";
        }

        if (!$this->name) {
            $errors[] = "Name is empty";
        }

        if (!$this->type) {
            $errors[] = "Type is empty";
        } elseif (!in_array($this->type, Location::TYPES, true)) {
            $errors[] = "Unknown type `$this->type`";
        }

        if (!$this->status) {
            $errors[] = "Status is empty";
        } elseif (!in_array($this->status, Location::STATUSES, true)) {
            $errors[] = "Unknown status `$this->status`";
        }

        if (!$this->description) {
            $errors[] = "Description is empty";
        }

        if ($errors) {
            if ($verify) {
                throw new InvalidArgumentsException($errors);
            }
            return false;
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getModelParams(bool $validate = true): array
    {
        if ($validate) {
            $this->isValid(true);
        }

        return [
            'coords' => $this->coords,
            'lat' => $this->coords->getLat(),
            'lng' => $this->coords->getLng(),
            'name' => $this->name,
            'type' => $this->type,
            'status' => $this->status,
            'description' => $this->description,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getSearchParams(bool $validate = true): array
    {
        if ($validate) {
            try {
                PointValidator::isValid($this->coords, true);
            } catch (\InvalidArgumentException $e) {
                throw new \InvalidArgumentException("Invalid coords: {$e->getMessage()}");
            }
        }

        return [
            'lat' => $this->coords->getLat(),
            'lng' => $this->coords->getLng(),
        ];
    }

    /**
     * @return Point
     */
    public function getCoords(): Point
    {
        return $this->coords;
    }

    /**
     * @param Point $coords
     * @return LocationBlueprint
     */
    public function setCoords(Point $coords): LocationBlueprint
    {
        $this->coords = $coords;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return LocationBlueprint
     */
    public function setName(string $name): LocationBlueprint
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return LocationBlueprint
     */
    public function setType(string $type): LocationBlueprint
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return LocationBlueprint
     */
    public function setStatus(string $status): LocationBlueprint
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return LocationBlueprint
     */
    public function setDescription(string $description): LocationBlueprint
    {
        $this->description = $description;
        return $this;
    }
}