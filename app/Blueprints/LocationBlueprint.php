<?php /** @noinspection PhpUnused */

namespace App\Blueprints;

use app\Exceptions\InvalidArgumentsException;
use App\Models\Common\LmpModel;
use App\Models\Feature;
use App\Models\Location;
use App\Models\LocationType;
use App\User;
use app\Validators\PointValidator;
use app\Validators\RelatedUserValidator;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class LocationBlueprint implements Blueprint
{
    protected Point $coords;
    protected LocationType $type;
    protected User $user;
    protected string $title;
    /** @var string|null */
    protected $description;
    protected string $status = Location::STATUS_UNVERIFIED;
    /** @var Feature[] */
    protected array $features = [];

    public function __construct(Point $coords, LocationType $type, User $user, string $title)
    {
        $this->coords = $coords;
        $this->type = $type;
        $this->user = $user;
        $this->title = $title;
    }

    /**
     * @param Location|LmpModel $model
     * @return static
     */
    public static function fromModel(LmpModel $model): self
    {
        return (new static(
            $model->coords,
            $model->type,
            $model->user,
            $model->title
        ))
            ->setStatus($model->status)
            ->setDescription($model->description);
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

        foreach (array_keys($this->features) as $featureId) {
            if (!in_array($featureId, Feature::IDS, true)) {
                $errors[] = "Invalid feature ID `$featureId`";
            }
        }

        try {
            RelatedUserValidator::isValid($this->user, true);
        } catch (\InvalidArgumentException $e) {
            $errors[] = "Invalid user: {$e->getMessage()}";
        }

        if (!$this->title) {
            $errors[] = "Title is empty";
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
            'location_type_id' => $this->type->id,
            'user_id' => $this->user->id,
            'coords' => $this->coords,
            'title' => $this->title,
            'status' => $this->status,
            'description' => $this->description ?: null,
        ];
    }

    public function getFeatureLocationsParams(Location $location, bool $validate = true): array
    {
        if ($validate) {
            $this->isValid(true);
        }

        $params = [];
        foreach ($this->features as $featureId => $description) {
            $params[] = [
                'feature_id' => $featureId,
                'location_id' => $location->id,
                'user_id' => $this->user->id,
                'description' => $description,
            ];
        }

        return $params;
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return LocationBlueprint
     */
    public function setTitle(string $title): LocationBlueprint
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return LocationType
     */
    public function getType(): LocationType
    {
        return $this->type;
    }

    /**
     * @param LocationType $type
     * @return LocationBlueprint
     */
    public function setType(LocationType $type): LocationBlueprint
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
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description ?: null;
    }

    /**
     * @param string|null $description
     * @return LocationBlueprint
     */
    public function setDescription(?string $description): LocationBlueprint
    {
        $this->description = $description ?: null;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return LocationBlueprint
     */
    public function setUser(User $user): LocationBlueprint
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Feature[]
     */
    public function getFeatures(): array
    {
        return $this->features;
    }

    /**
     * @param string $featureId
     * @param string|null $description
     * @return LocationBlueprint
     */
    public function addFeature(string $featureId, string $description = null): LocationBlueprint
    {
        $this->features[$featureId] = $description;
        return $this;
    }
}