<?php

declare(strict_types=1);

namespace Akeneo\Tool\Bundle\MeasureBundle\Provider;

use Akeneo\Tool\Bundle\MeasureBundle\Model\MeasurementFamily;
use Akeneo\Tool\Bundle\MeasureBundle\Persistence\MeasurementFamilyRepositoryInterface;

/**
 * @author    Valentin Dijkstra <valentin.dijkstra@akeneo.com>
 * @copyright 2020 Akeneo SAS (https://www.akeneo.com)
 */
class LegacyMeasurementProvider
{
    /** @var MeasurementFamilyRepositoryInterface */
    private $measurementFamilyRepository;

    /** @var LegacyMeasurementAdapter */
    private $adapter;

    public function __construct(
        MeasurementFamilyRepositoryInterface $measurementFamilyRepository,
        LegacyMeasurementAdapter $adapter
    ) {
        $this->measurementFamilyRepository = $measurementFamilyRepository;
        $this->adapter = $adapter;
    }

    public function getMeasurementFamilies(): array
    {
        $measurementFamilies = array_map(function (MeasurementFamily $family) {
            return $this->adapter->adapts($family);
        }, iterator_to_array($this->measurementFamilyRepository->all()));

        $result = [];
        foreach ($measurementFamilies as $familyCode => $family) {
            $result = array_merge($result, $family);
        }

        return $result;
    }
}
