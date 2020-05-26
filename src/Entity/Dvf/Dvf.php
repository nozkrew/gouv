<?php

namespace App\Entity\Dvf;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dvf
 *
 * @ORM\Table(name="dvf")
 * @ORM\Entity
 */
class Dvf
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="id_mutation", type="string", length=255, nullable=true)
     */
    private $idMutation;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_mutation", type="date", nullable=true)
     */
    private $dateMutation;

    /**
     * @var int|null
     *
     * @ORM\Column(name="numero_disposition", type="integer", nullable=true)
     */
    private $numeroDisposition;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nature_mutation", type="string", length=255, nullable=true)
     */
    private $natureMutation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="valeur_fonciere", type="decimal", precision=12, scale=2, nullable=true)
     */
    private $valeurFonciere;

    /**
     * @var int|null
     *
     * @ORM\Column(name="adresse_numero", type="integer", nullable=true)
     */
    private $adresseNumero;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse_suffixe", type="string", length=255, nullable=true)
     */
    private $adresseSuffixe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse_nom_voie", type="string", length=255, nullable=true)
     */
    private $adresseNomVoie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse_code_voie", type="string", length=255, nullable=true)
     */
    private $adresseCodeVoie;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_postal", type="string", length=255, nullable=true)
     */
    private $codePostal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_commune", type="string", length=255, nullable=true)
     */
    private $codeCommune;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_commune", type="string", length=255, nullable=true)
     */
    private $nomCommune;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_departement", type="string", length=255, nullable=true)
     */
    private $codeDepartement;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ancien_code_commune", type="string", length=255, nullable=true)
     */
    private $ancienCodeCommune;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ancien_nom_commune", type="string", length=255, nullable=true)
     */
    private $ancienNomCommune;

    /**
     * @var string|null
     *
     * @ORM\Column(name="id_parcelle", type="string", length=255, nullable=true)
     */
    private $idParcelle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ancien_id_parcelle", type="string", length=255, nullable=true)
     */
    private $ancienIdParcelle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero_volume", type="string", length=255, nullable=true)
     */
    private $numeroVolume;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lot1_numero", type="string", length=255, nullable=true)
     */
    private $lot1Numero;

    /**
     * @var float|null
     *
     * @ORM\Column(name="lot1_surface_carrez", type="float", precision=9, scale=2, nullable=true)
     */
    private $lot1SurfaceCarrez;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lot2_numero", type="string", length=255, nullable=true)
     */
    private $lot2Numero;

    /**
     * @var float|null
     *
     * @ORM\Column(name="lot2_surface_carrez", type="float", precision=9, scale=2, nullable=true)
     */
    private $lot2SurfaceCarrez;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lot3_numero", type="string", length=255, nullable=true)
     */
    private $lot3Numero;

    /**
     * @var float|null
     *
     * @ORM\Column(name="lot3_surface_carrez", type="float", precision=9, scale=2, nullable=true)
     */
    private $lot3SurfaceCarrez;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lot4_numero", type="string", length=255, nullable=true)
     */
    private $lot4Numero;

    /**
     * @var float|null
     *
     * @ORM\Column(name="lot4_surface_carrez", type="float", precision=9, scale=2, nullable=true)
     */
    private $lot4SurfaceCarrez;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lot5_numero", type="string", length=255, nullable=true)
     */
    private $lot5Numero;

    /**
     * @var float|null
     *
     * @ORM\Column(name="lot5_surface_carrez", type="float", precision=9, scale=2, nullable=true)
     */
    private $lot5SurfaceCarrez;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nombre_lots", type="integer", nullable=true)
     */
    private $nombreLots;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_type_local", type="string", length=255, nullable=true)
     */
    private $codeTypeLocal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_local", type="string", length=255, nullable=true)
     */
    private $typeLocal;

    /**
     * @var float|null
     *
     * @ORM\Column(name="surface_reelle_bati", type="float", precision=9, scale=2, nullable=true)
     */
    private $surfaceReelleBati;

    /**
     * @var int|null
     *
     * @ORM\Column(name="nombre_pieces_principales", type="integer", nullable=true)
     */
    private $nombrePiecesPrincipales;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_nature_culture", type="string", length=255, nullable=true)
     */
    private $codeNatureCulture;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nature_culture", type="string", length=255, nullable=true)
     */
    private $natureCulture;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_nature_culture_speciale", type="string", length=255, nullable=true)
     */
    private $codeNatureCultureSpeciale;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nature_culture_speciale", type="string", length=255, nullable=true)
     */
    private $natureCultureSpeciale;

    /**
     * @var float|null
     *
     * @ORM\Column(name="surface_terrain", type="float", precision=12, scale=2, nullable=true)
     */
    private $surfaceTerrain;

    /**
     * @var float|null
     *
     * @ORM\Column(name="longitude", type="float", precision=9, scale=7, nullable=true)
     */
    private $longitude;

    /**
     * @var float|null
     *
     * @ORM\Column(name="latitude", type="float", precision=9, scale=7, nullable=true)
     */
    private $latitude;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMutation(): ?string
    {
        return $this->idMutation;
    }

    public function setIdMutation(?string $idMutation): self
    {
        $this->idMutation = $idMutation;

        return $this;
    }

    public function getDateMutation(): ?\DateTimeInterface
    {
        return $this->dateMutation;
    }

    public function setDateMutation(?\DateTimeInterface $dateMutation): self
    {
        $this->dateMutation = $dateMutation;

        return $this;
    }

    public function getNumeroDisposition(): ?int
    {
        return $this->numeroDisposition;
    }

    public function setNumeroDisposition(?int $numeroDisposition): self
    {
        $this->numeroDisposition = $numeroDisposition;

        return $this;
    }

    public function getNatureMutation(): ?string
    {
        return $this->natureMutation;
    }

    public function setNatureMutation(?string $natureMutation): self
    {
        $this->natureMutation = $natureMutation;

        return $this;
    }

    public function getValeurFonciere(): ?string
    {
        return $this->valeurFonciere;
    }

    public function setValeurFonciere(?string $valeurFonciere): self
    {
        $this->valeurFonciere = $valeurFonciere;

        return $this;
    }

    public function getAdresseNumero(): ?int
    {
        return $this->adresseNumero;
    }

    public function setAdresseNumero(?int $adresseNumero): self
    {
        $this->adresseNumero = $adresseNumero;

        return $this;
    }

    public function getAdresseSuffixe(): ?string
    {
        return $this->adresseSuffixe;
    }

    public function setAdresseSuffixe(?string $adresseSuffixe): self
    {
        $this->adresseSuffixe = $adresseSuffixe;

        return $this;
    }

    public function getAdresseNomVoie(): ?string
    {
        return $this->adresseNomVoie;
    }

    public function setAdresseNomVoie(?string $adresseNomVoie): self
    {
        $this->adresseNomVoie = $adresseNomVoie;

        return $this;
    }

    public function getAdresseCodeVoie(): ?string
    {
        return $this->adresseCodeVoie;
    }

    public function setAdresseCodeVoie(?string $adresseCodeVoie): self
    {
        $this->adresseCodeVoie = $adresseCodeVoie;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getCodeCommune(): ?string
    {
        return $this->codeCommune;
    }

    public function setCodeCommune(?string $codeCommune): self
    {
        $this->codeCommune = $codeCommune;

        return $this;
    }

    public function getNomCommune(): ?string
    {
        return $this->nomCommune;
    }

    public function setNomCommune(?string $nomCommune): self
    {
        $this->nomCommune = $nomCommune;

        return $this;
    }

    public function getCodeDepartement(): ?string
    {
        return $this->codeDepartement;
    }

    public function setCodeDepartement(?string $codeDepartement): self
    {
        $this->codeDepartement = $codeDepartement;

        return $this;
    }

    public function getAncienCodeCommune(): ?string
    {
        return $this->ancienCodeCommune;
    }

    public function setAncienCodeCommune(?string $ancienCodeCommune): self
    {
        $this->ancienCodeCommune = $ancienCodeCommune;

        return $this;
    }

    public function getAncienNomCommune(): ?string
    {
        return $this->ancienNomCommune;
    }

    public function setAncienNomCommune(?string $ancienNomCommune): self
    {
        $this->ancienNomCommune = $ancienNomCommune;

        return $this;
    }

    public function getIdParcelle(): ?string
    {
        return $this->idParcelle;
    }

    public function setIdParcelle(?string $idParcelle): self
    {
        $this->idParcelle = $idParcelle;

        return $this;
    }

    public function getAncienIdParcelle(): ?string
    {
        return $this->ancienIdParcelle;
    }

    public function setAncienIdParcelle(?string $ancienIdParcelle): self
    {
        $this->ancienIdParcelle = $ancienIdParcelle;

        return $this;
    }

    public function getNumeroVolume(): ?string
    {
        return $this->numeroVolume;
    }

    public function setNumeroVolume(?string $numeroVolume): self
    {
        $this->numeroVolume = $numeroVolume;

        return $this;
    }

    public function getLot1Numero(): ?string
    {
        return $this->lot1Numero;
    }

    public function setLot1Numero(?string $lot1Numero): self
    {
        $this->lot1Numero = $lot1Numero;

        return $this;
    }

    public function getLot1SurfaceCarrez(): ?float
    {
        return $this->lot1SurfaceCarrez;
    }

    public function setLot1SurfaceCarrez(?float $lot1SurfaceCarrez): self
    {
        $this->lot1SurfaceCarrez = $lot1SurfaceCarrez;

        return $this;
    }

    public function getLot2Numero(): ?string
    {
        return $this->lot2Numero;
    }

    public function setLot2Numero(?string $lot2Numero): self
    {
        $this->lot2Numero = $lot2Numero;

        return $this;
    }

    public function getLot2SurfaceCarrez(): ?float
    {
        return $this->lot2SurfaceCarrez;
    }

    public function setLot2SurfaceCarrez(?float $lot2SurfaceCarrez): self
    {
        $this->lot2SurfaceCarrez = $lot2SurfaceCarrez;

        return $this;
    }

    public function getLot3Numero(): ?string
    {
        return $this->lot3Numero;
    }

    public function setLot3Numero(?string $lot3Numero): self
    {
        $this->lot3Numero = $lot3Numero;

        return $this;
    }

    public function getLot3SurfaceCarrez(): ?float
    {
        return $this->lot3SurfaceCarrez;
    }

    public function setLot3SurfaceCarrez(?float $lot3SurfaceCarrez): self
    {
        $this->lot3SurfaceCarrez = $lot3SurfaceCarrez;

        return $this;
    }

    public function getLot4Numero(): ?string
    {
        return $this->lot4Numero;
    }

    public function setLot4Numero(?string $lot4Numero): self
    {
        $this->lot4Numero = $lot4Numero;

        return $this;
    }

    public function getLot4SurfaceCarrez(): ?float
    {
        return $this->lot4SurfaceCarrez;
    }

    public function setLot4SurfaceCarrez(?float $lot4SurfaceCarrez): self
    {
        $this->lot4SurfaceCarrez = $lot4SurfaceCarrez;

        return $this;
    }

    public function getLot5Numero(): ?string
    {
        return $this->lot5Numero;
    }

    public function setLot5Numero(?string $lot5Numero): self
    {
        $this->lot5Numero = $lot5Numero;

        return $this;
    }

    public function getLot5SurfaceCarrez(): ?float
    {
        return $this->lot5SurfaceCarrez;
    }

    public function setLot5SurfaceCarrez(?float $lot5SurfaceCarrez): self
    {
        $this->lot5SurfaceCarrez = $lot5SurfaceCarrez;

        return $this;
    }

    public function getNombreLots(): ?int
    {
        return $this->nombreLots;
    }

    public function setNombreLots(?int $nombreLots): self
    {
        $this->nombreLots = $nombreLots;

        return $this;
    }

    public function getCodeTypeLocal(): ?string
    {
        return $this->codeTypeLocal;
    }

    public function setCodeTypeLocal(?string $codeTypeLocal): self
    {
        $this->codeTypeLocal = $codeTypeLocal;

        return $this;
    }

    public function getTypeLocal(): ?string
    {
        return $this->typeLocal;
    }

    public function setTypeLocal(?string $typeLocal): self
    {
        $this->typeLocal = $typeLocal;

        return $this;
    }

    public function getSurfaceReelleBati(): ?float
    {
        return $this->surfaceReelleBati;
    }

    public function setSurfaceReelleBati(?float $surfaceReelleBati): self
    {
        $this->surfaceReelleBati = $surfaceReelleBati;

        return $this;
    }

    public function getNombrePiecesPrincipales(): ?int
    {
        return $this->nombrePiecesPrincipales;
    }

    public function setNombrePiecesPrincipales(?int $nombrePiecesPrincipales): self
    {
        $this->nombrePiecesPrincipales = $nombrePiecesPrincipales;

        return $this;
    }

    public function getCodeNatureCulture(): ?string
    {
        return $this->codeNatureCulture;
    }

    public function setCodeNatureCulture(?string $codeNatureCulture): self
    {
        $this->codeNatureCulture = $codeNatureCulture;

        return $this;
    }

    public function getNatureCulture(): ?string
    {
        return $this->natureCulture;
    }

    public function setNatureCulture(?string $natureCulture): self
    {
        $this->natureCulture = $natureCulture;

        return $this;
    }

    public function getCodeNatureCultureSpeciale(): ?string
    {
        return $this->codeNatureCultureSpeciale;
    }

    public function setCodeNatureCultureSpeciale(?string $codeNatureCultureSpeciale): self
    {
        $this->codeNatureCultureSpeciale = $codeNatureCultureSpeciale;

        return $this;
    }

    public function getNatureCultureSpeciale(): ?string
    {
        return $this->natureCultureSpeciale;
    }

    public function setNatureCultureSpeciale(?string $natureCultureSpeciale): self
    {
        $this->natureCultureSpeciale = $natureCultureSpeciale;

        return $this;
    }

    public function getSurfaceTerrain(): ?float
    {
        return $this->surfaceTerrain;
    }

    public function setSurfaceTerrain(?float $surfaceTerrain): self
    {
        $this->surfaceTerrain = $surfaceTerrain;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }


}
