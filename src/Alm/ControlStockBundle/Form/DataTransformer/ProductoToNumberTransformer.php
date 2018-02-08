<?php  
namespace Alm\ControlStockBundle\Form\DataTransformer;

use Alm\ControlStockBundle\Entity\AlmAdmProducto;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ProductoToNumberTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (AlmAdmProducto) to a string (number).
     *
     * @param  AlmAdmProducto|null $producto
     * @return string
     */
    public function transform($producto)
    {
        if (null === $producto) {
            return '';
        }

        return $producto->getCodpro();
    }

    /**
     * Transforms a string (number) to an object (producto).
     *
     * @param  string $productoNumber
     * @return AlmAdmProducto|null
     * @throws TransformationFailedException if object (producto) is not found.
     */
    public function reverseTransform($productoNumber)
    {
        // no producto number? It's optional, so that's ok
        if (!$productoNumber) {
            return;
        }

        $producto = $this->manager
            ->getRepository('AlmControlStockBundle:AlmAdmProducto')
            // query for the producto with this id
            ->findOneByCodpro($productoNumber)
        ;

        if (null === $producto) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An producto with number "%s" does not exist!',
                $productoNumber
            ));
        }

        return $producto;
    }
}

?>