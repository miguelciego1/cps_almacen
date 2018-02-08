<?php  
namespace Alm\ControlStockBundle\Form\DataTransformer;

use Alm\ControlStockBundle\Entity\LabAlmProductolab;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ProductoLabToNumberTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (LabAlmProductolab) to a string (number).
     *
     * @param  LabAlmProductolab|null $productoLab
     * @return string
     */
    public function transform($productoLab)
    {
        if (null === $productoLab) {
            return '';
        }

        return $productoLab->getProducto()->getCodpro();
    }

    /**
     * Transforms a string (number) to an object (productoLab).
     *
     * @param  string $productoLabNumber
     * @return LabAlmProductolab|null
     * @throws TransformationFailedException if object (productoLab) is not found.
     */
    public function reverseTransform($productoLabNumber)
    {
        // no productoLab number? It's optional, so that's ok
        if (!$productoLabNumber) {
            return;
        }

        $productoLab = $this->manager
            ->getRepository('AlmControlStockBundle:LabAlmProductolab')
            // query for the productoLab with this id
            ->findOneByProductoCodigo($productoLabNumber)
        ;

        if (null === $productoLab) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An productoLab with number "%s" does not exist!',
                $productoLabNumber
            ));
        }

        return $productoLab;
    }
}

?>