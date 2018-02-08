<?php

namespace Alm\ControlStockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * LabAlmUsuario
 *
 * @ORM\Table(name="lab_alm_usuario", uniqueConstraints={@ORM\UniqueConstraint(name="login", columns={"login"})}, indexes={@ORM\Index(name="empleado_id", columns={"empleado_id"})})
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"login", "empleado"},
 *     errorPath="empleado",
 *     message="Este empleado ya existe"
 * )
 */
class LabAlmUsuario implements UserInterface, EquatableInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="login", type="integer", nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=1, nullable=false)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=90, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="seccion", type="string", length=50, nullable=false)
     */
    private $seccion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creado_el", type="datetime", nullable=false)
     */
    private $creadoEl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modificado_el", type="datetime", nullable=false)
     */
    private $modificadoEl;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Alm\ControlStockBundle\Entity\PerEmpleado
     *
     * @ORM\OneToOne(targetEntity="Cps\Personal\ArchivoBundle\Entity\Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="empleado_id", referencedColumnName="id")
     * })
     */
    protected $empleado;

    // INICIO Metodos requerido por la interfaz UserInterface ====================================

      public function getUsername(){
          return $this->login;
      }

      public function isEqualTo(UserInterface $usuario){
          return $this->getUsername() == $usuario->getUsername();
      }

      public function eraseCredentials(){
      }

      public function getRoles(){
          $resp = 'ROLE_EMPADM';
          return array($resp);
      }

      public function getSalt(){
          return false;
      }

      // Metodos requerido cuando la entidad USUARIO se relaciona con Cargo o Rol ==================

      public function serialize(){
         return serialize($this->id);
      }


       public function unserialize($data){
        $this->id = unserialize($data);
      }

      public function __toString(){
      return $this->empleado->getNomCompleto();
     }
    /**
     * @ORM\PrePersist
     */
     public function PrePersist(){
     $this->login    = strtolower($this->login);
     $this->creadoEl = new \DateTime();
     }

    /**
     * @ORM\PreUpdate
     */
    public function PreUpdate(){
     $this->login    = strtolower($this->login);
     $this->eliminadoEl = new \DateTime();
    }

    /**
     * Set login
     *
     * @param integer $login
     * @return LabAlmUsuario
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return integer
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set estado
     *
     * @param string $estado
     * @return LabAlmUsuario
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return LabAlmUsuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set seccion
     *
     * @param string $seccion
     * @return LabAlmUsuario
     */
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * Get seccion
     *
     * @return string
     */
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set creadoEl
     *
     * @param \DateTime $creadoEl
     * @return LabAlmUsuario
     */
    public function setCreadoEl($creadoEl)
    {
        $this->creadoEl = $creadoEl;

        return $this;
    }

    /**
     * Get creadoEl
     *
     * @return \DateTime
     */
    public function getCreadoEl()
    {
        return $this->creadoEl;
    }

    /**
     * Set modificadoEl
     *
     * @param \DateTime $modificadoEl
     * @return LabAlmUsuario
     */
    public function setModificadoEl($modificadoEl)
    {
        $this->modificadoEl = $modificadoEl;

        return $this;
    }

    /**
     * Get modificadoEl
     *
     * @return \DateTime
     */
    public function getModificadoEl()
    {
        return $this->modificadoEl;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set empleado
     *
     * @param \Cps\Personal\ArchivoBundle\Entity\Empleado $empleado
     * @return LabAlmUsuario
     */
    public function setEmpleado(\Cps\Personal\ArchivoBundle\Entity\Empleado $empleado = null)
    {
        $this->empleado = $empleado;

        return $this;
    }

    /**
     * Get empleado
     *
     * @return \Cps\Personal\ArchivoBundle\Entity\Empleado
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }
}
