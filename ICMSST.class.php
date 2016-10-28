<?php

class ICMSST {

    //BASE ICMS INTER
    private $ValordoProduto;
    private $ValorDoFrete;
    private $ValorSeguro;
    private $ValorOutrasDespesas;
    private $ValorDescontos;
    private $BaseDoICMS;
    //VALOR ICMS INTER
    private $AliquotaICMSInter;
    private $ValorDoICMS;
    //BASE ICMS ST
    private $MVA;
    private $BaseDoICMSST;
    private $AliquotaICMSIntra;
    public $ValorICMSST;

    function __construct() {
        
    }

    private function CalculaBaseICMS() {
        $this->BaseDoICMS = ($this->ValordoProduto + $this->ValorDoFrete + $this->ValorSeguro + $this->ValorOutrasDespesas - $this->ValorDescontos);
        return $this->BaseDoICMS;
    }

    private function CalculaValorICMS() {
        $this->ValorDoICMS = $this->CalculaBaseICMS() * ($this->AliquotaICMSInter / 100);
        return $this->ValorDoICMS;
    }

    private function CalculaBaseICMSST() {
        $this->BaseDoICMSST = ($this->ValordoProduto + $this->ValorDoIPI + $this->ValorDoFrete + $this->ValorSeguro + $this->ValorOutrasDespesas - $this->ValorDescontos) * (1 + ($this->MVA / 100));
        return $this->BaseDoICMSST;
    }

    public function CalculaValorICMSST($ValordoProduto, $MVA, $AliquotaICMSInter, $AliquotaICMSIntra, $ValorDoFrete = null, $ValorSeguro = null, $ValorOutrasDespesas = null, $ValorDescontos = null, $ValorDoIPI = null) {
        $this->ValordoProduto = $ValordoProduto;
        $this->MVA = $MVA;
        $this->AliquotaICMSInter = $AliquotaICMSInter;
        $this->AliquotaICMSIntra = $AliquotaICMSIntra;
        $this->ValorDoFrete = $ValorDoFrete;
        $this->ValorSeguro = $ValorSeguro;
        $this->ValorOutrasDespesas = $ValorOutrasDespesas;
        $this->ValorDescontos = $ValorDescontos;
        $this->ValorDoIPI = $ValorDoIPI;

        $this->ValorICMSST = ($this->CalculaBaseICMSST() * ($this->AliquotaICMSIntra / 100) - $this->CalculaValorICMS());
        return $this->ValorICMSST;
    }

}
