<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('airports')->insert([
            ['state_id' => DB::table('states')->select('id')->where('name', 'SE')->first()->id, 'initials' =>	'AJU', 'name' =>'Santa Maria, Aracaju'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'PA')->first()->id, 'initials' =>	'BEL', 'name' =>'Val de Caes, Belém'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'RS')->first()->id, 'initials' =>	'BGX', 'name' =>'Bagé'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'SC')->first()->id, 'initials' =>	'BNU', 'name' =>'Blumenau'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'BA')->first()->id, 'initials' =>	'BPS', 'name' =>'Porto Seguro'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'DF')->first()->id, 'initials' =>	'BSB', 'name' =>'Juscelino Kubitschek, Brasília'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'RO')->first()->id, 'initials' =>	'BVB', 'name' =>'Boa Vista'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'PR')->first()->id, 'initials' =>	'CAC', 'name' =>'Cascavel'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'MT')->first()->id, 'initials' =>	'CGB', 'name' =>'Cuiabá'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'SP')->first()->id, 'initials' =>	'CGH', 'name' =>'Congonhas, São Paulo'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'MS')->first()->id, 'initials' =>	'CGR', 'name' =>'Campo Grande'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'MG')->first()->id, 'initials' =>	'CNF', 'name' =>'Confins, Belo Horizonte'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'PB')->first()->id, 'initials' =>	'CPV', 'name' =>'João Suassuna, Campina Grande'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'PR')->first()->id, 'initials' =>	'CWB', 'name' =>'Afonso Pena, Curitiba'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'RS')->first()->id, 'initials' =>	'CXJ', 'name' =>'Caxias do Sul'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'SC')->first()->id, 'initials' =>	'FLN', 'name' =>'Florianópolis'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'CE')->first()->id, 'initials' =>	'FOR', 'name' =>'Pinto Martins, Fortaleza'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'RJ')->first()->id, 'initials' =>	'GIG', 'name' =>'Galeão, Rio de Janeiro'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'PR')->first()->id, 'initials' =>	'GPB', 'name' =>'Guarapuava'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'SP')->first()->id, 'initials' =>	'GRU', 'name' =>'Franco Montoro, São Paulo'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'GO')->first()->id, 'initials' =>	'GYN', 'name' =>'Goiânia'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'PR')->first()->id, 'initials' =>	'IGU', 'name' =>'Cataratas, Foz do Iguaçu'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'MA')->first()->id, 'initials' =>	'IMP', 'name' =>'Prefeito Renato Moreira, Imperatriz'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'BA')->first()->id, 'initials' =>	'IOS', 'name' =>'Ilhéus'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'CE')->first()->id, 'initials' =>	'JDO', 'name' =>'Cariri, Juazeiro do Norte'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'SC')->first()->id, 'initials' =>	'JOI', 'name' =>'Joinville'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'PB')->first()->id, 'initials' =>	'JPA', 'name' =>'Pres. Castro Pinto, João Pessoa'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'PR')->first()->id, 'initials' =>	'LDB', 'name' =>'Londrina'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'RS')->first()->id, 'initials' =>	'LAJ', 'name' =>'Lages'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'AM')->first()->id, 'initials' =>	'MAO', 'name' =>'Eduardo Gomes, Manaus'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'AL')->first()->id, 'initials' =>	'MCZ', 'name' =>'Zumbi dos Palmares, Maceió'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'PR')->first()->id, 'initials' =>	'MGF', 'name' =>'Maringá'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'RN')->first()->id, 'initials' =>	'NAT', 'name' =>'Augusto Severo, Natal'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'RS')->first()->id, 'initials' =>	'PET', 'name' =>'Pelotas'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'MG')->first()->id, 'initials' =>	'PLU', 'name' =>'da Pampulha, Belo Horizonte'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'PI')->first()->id, 'initials' =>	'PHB', 'name' =>'Parnaíba'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'RS')->first()->id, 'initials' =>	'PFB', 'name' =>'Passo Fundo'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'TO')->first()->id, 'initials' =>	'PMW', 'name' =>'Palmas'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'PE')->first()->id, 'initials' =>	'PNZ', 'name' =>'Petrolina'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'RS')->first()->id, 'initials' =>	'POA', 'name' =>'Salgado Filho, Porto Alegre'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'PE')->first()->id, 'initials' =>	'REC', 'name' =>'Guararapes, Recife'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'RS')->first()->id, 'initials' =>	'RIA', 'name' =>'Santa Maria'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'RJ')->first()->id, 'initials' =>	'SDU', 'name' =>'Santos Dumont, Rio de Janeiro'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'MA')->first()->id, 'initials' =>	'SLZ', 'name' =>'Marechal Cunha Machado, São Luis'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'SP')->first()->id, 'initials' =>	'SOD', 'name' =>'Sorocaba'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'BA')->first()->id, 'initials' =>	'SSA', 'name' =>'Salvador'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'PI')->first()->id, 'initials' =>	'THE', 'name' =>'Senador Petrônio Portela, Teresina'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'SP')->first()->id, 'initials' =>	'VCP', 'name' =>'Campinas'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'MG')->first()->id, 'initials' =>	'UDI', 'name' =>'Uberlândia'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'BA')->first()->id, 'initials' =>	'VDC', 'name' =>'Vitória da Conquista'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'ES')->first()->id, 'initials' =>	'VIX', 'name' =>'Vitória'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'SC')->first()->id, 'initials' =>	'XAP', 'name' =>'Chapecó'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'AP')->first()->id, 'initials' =>	'MCP', 'name' =>'Internacional de Macapá'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'RR')->first()->id, 'initials' =>	'SBBV','name' =>'Atlas Brasil Cantanhede, Boa Vista'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'SP')->first()->id, 'initials' =>	'SBDN','name' =>'Presidente Prudente'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'SP')->first()->id, 'initials' =>	'SDAD','name' =>'Everaldo Moraes Barreto (Adamantina)'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'SP')->first()->id, 'initials' =>    'SDAI','name' =>'Americana Sao Paulo SP'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'SC')->first()->id, 'initials' =>    'JJG', 'name' =>'Jaguaruna'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'MG')->first()->id, 'initials' =>	'IZA', 'name' =>'Regional Presidente Itamar Franco (Zona da Mata)'],
            ['state_id' => DB::table('states')->select('id')->where('name', 'MT')->first()->id, 'initials' =>	'ROO', 'name' =>'Municipal Maestro Marinho Franco (Rondonópolis)']
        ]);
    }
}
