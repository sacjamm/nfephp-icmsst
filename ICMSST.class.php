<?php

class ICMSST {

    //BASE ICMS INTER
    public $ValordoProduto;
    public $ValorDoFrete;
    public $ValorSeguro;
    public $ValorOutrasDespesas;
    public $ValorDescontos;
    public $BaseDoICMS;
    //VALOR ICMS INTER
    public $AliquotaICMSInter;
    public $ValorDoICMS;
    //BASE ICMS ST
    public $MVA;
    public $BaseDoICMSST;
    public $AliquotaICMSIntra;
    public $ValorICMSST;

    function __construct() {
        
    }

    public function CalculaBaseICMS($ValordoProduto, $ValorDoFrete = null, $ValorSeguro = null, $ValorOutrasDespesas = null, $ValorDescontos = null) {
        $this->ValordoProduto = $ValordoProduto;
        $this->ValorDoFrete = $ValorDoFrete;
        $this->ValorSeguro = $ValorSeguro;
        $this->ValorOutrasDespesas = $ValorOutrasDespesas;
        $this->ValorDescontos = $ValorDescontos;

        $this->BaseDoICMS = ($this->ValordoProduto + $this->ValorDoFrete + $this->ValorSeguro + $this->ValorOutrasDespesas - $this->ValorDescontos);
        return $this->BaseDoICMS;
    }

    public function CalculaValorICMS($AliquotaICMSInter) {
        $this->AliquotaICMSInter = $AliquotaICMSInter;
        $this->ValorDoICMS = $this->BaseDoICMS * ($this->AliquotaICMSInter / 100);
        return $this->ValorDoICMS;
    }

    public function CalculaBaseICMSST($ValorDoIPI,$MVA) {
        $this->ValorDoIPI = $ValorDoIPI;
        $this->MVA = $MVA;
        $this->BaseDoICMSST = ($this->ValordoProduto + $this->ValorDoIPI + $this->ValorDoFrete + $this->ValorSeguro + $this->ValorOutrasDespesas - $this->ValorDescontos) * (1 + ($this->MVA / 100));
        return $this->BaseDoICMSST;
    }
//
    public function CalculaValorICMSST($AliquotaICMSIntra) {
        $this->AliquotaICMSIntra = $AliquotaICMSIntra;

        $this->ValorICMSST = ($this->BaseDoICMSST * ($this->AliquotaICMSIntra / 100) - $this->ValorDoICMS);
        return $this->ValorICMSST;
    }
    
    public function TotaldaNota(){
        $this->ValordoProduto = $this->ValordoProduto + $this->ValorICMSST;
        return $this->ValordoProduto;
    }

}

//Exemplo de utilização
$valorProduto = 79.99;
$frete = 14.99;
$seguro = 0.00;
$despesas = 6.62;
$desconto = 0.00;

$aliquotaICMSInter = 4;

$valorIPI = 0.00;
$MVA = 37.22;
$AliquotaICMSIntra = 18.42;
echo '<pre>';
$icmsst = new ICMSST;
echo 'Base de Calculo ICMS: ' . $icmsst->CalculaBaseICMS($valorProduto, $frete, $seguro, $despesas, $desconto) . '<br>';
echo 'Valor do ICMS: '.$icmsst->CalculaValorICMS($aliquotaICMSInter).'<br>';
echo 'Base de Calculo ICMS ST: '.$icmsst->CalculaBaseICMSST($valorIPI,$MVA)."<br>";
echo 'Valor ICMS ST: '. $icmsst->CalculaValorICMSST($AliquotaICMSIntra)."<br>";
echo 'Valor Total da Nota: '. $icmsst->TotaldaNota();

echo '</pre>';
