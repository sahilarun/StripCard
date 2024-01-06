<?php

namespace Database\Seeders\Admin;

use App\Constants\GlobalConst;
use App\Models\Admin\SetupPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SetupPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages =  ["Home" => "/","About" => "/about","Services"=>"/services","Announcement" =>"announcement","Contact" => "/contact"];
        $data = [];
        foreach($pages as $item => $url) {
            $data[] = [
                'type'         => Str::slug(GlobalConst::SETUP_PAGE),
                'slug'         => Str::slug($item),
                'title'        => json_encode(
                    [
                        'title'     => $item
                    ],
                ),
                'url'          => $url,
                'last_edit_by' => 1,
                'status' => 1,
                'created_at'   => now(),
            ];
        }
        SetupPage::insert($data);
        $data =[
            [
                'type'         =>Str::slug(GlobalConst::USEFUL_LINKS),
                'slug'         =>'privacy-policy',
                'title'        => '{"language":{"en":{"title":"Privacy Policy"},"es":{"title":"pol\u00edtica de privacidad"}}}',
                'url'          => null,
                'details'          => '{"language":{"en":{"details":"<h3 style=\"margin-left:0px;\"><strong>What information do we collect?<\/strong><\/h3><p style=\"margin-left:0px;\">We gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\/p><h3 style=\"margin-left:0px;\"><strong>How do we protect your information?<\/strong><\/h3><p style=\"margin-left:0px;\">All provided delicate\/credit data is sent through Stripe.<br>After an exchange, your private data (credit cards, social security numbers, financials, and so on) won be put away on our workers.<\/p><h3 style=\"margin-left:0px;\"><strong>Do we disclose any information to outside parties?<\/strong><\/h3><p style=\"margin-left:0px;\">We don sell, exchange, or in any case move to outside gatherings by and by recognizable data. This does exclude confided in outsiders who help us in working our site, leading our business, or adjusting you, since those gatherings consent to keep this data private. We may likewise deliver your data when we accept discharge is suitable to follow the law, implement our site strategies, or ensure our own or others rights, property, or wellbeing.<\/p><h3 style=\"margin-left:0px;\"><strong>Childrens Online Privacy Protection Act Compliance<\/strong><\/h3><p style=\"margin-left:0px;\">We are consistent with the prerequisites of COPPA (Childrens Online Privacy Protection Act), we don gather any data from anybody under 13 years old. Our site, items, and administrations are completely coordinated to individuals who are in any event 13 years of age or more established.<\/p><h3 style=\"margin-left:0px;\"><strong>Changes to our Privacy Policy<\/strong><\/h3><p style=\"margin-left:0px;\">If we decide to change our privacy policy, we will post those changes on this page.<\/p><h3 style=\"margin-left:0px;\"><strong>How long we retain your information?<\/strong><\/h3><p style=\"margin-left:0px;\">At the point when you register for our site, we cycle and keep your information we have about you however long you don not erase the record or withdraw yourself (subject to laws and guidelines).<\/p><h2 style=\"margin-left:0px;text-align:center;\">&nbsp;<\/h2>"},"es":{"details":"<p>\u00bfQu\u00e9 informaci\u00f3n recopilamos?<\/p><p>Recopilamos sus datos cuando se registra en nuestro sitio, env\u00eda una solicitud, compra cualquier servicio, reacciona a una descripci\u00f3n general o completa una estructura. Cuando solicite asistencia o se registre en nuestro sitio, seg\u00fan corresponda, se le pedir\u00e1 que ingrese su: nombre, direcci\u00f3n de correo electr\u00f3nico o n\u00famero de tel\u00e9fono. No obstante, puede visitar nuestro sitio de forma an\u00f3nima.<\/p><p>\u00bfC\u00f3mo protegemos tu informaci\u00f3n?<\/p><p>Todos los datos delicados\/de cr\u00e9dito proporcionados se env\u00edan a trav\u00e9s de Stripe.<br>Despu\u00e9s de un intercambio, sus datos privados (tarjetas de cr\u00e9dito, n\u00fameros de seguridad social, datos financieros, etc.) se guardar\u00e1n en nuestros trabajadores.<\/p><p>\u00bfRevelamos informaci\u00f3n a terceros?<\/p><p>No vendemos, intercambiamos o, en cualquier caso, nos trasladamos a reuniones externas por y por datos reconocibles. Esto excluye a personas ajenas a la confianza que nos ayudan a trabajar en nuestro sitio, liderar nuestro negocio o ajustarlo, ya que esos grupos aceptan mantener estos datos privados. Tambi\u00e9n podemos entregar sus datos cuando aceptemos que la descarga es adecuada para cumplir con la ley, implementar las estrategias de nuestro sitio o garantizar nuestros derechos, propiedad o bienestar propios o ajenos.<\/p><p>Cumplimiento de la Ley de protecci\u00f3n de la privacidad en l\u00ednea de los ni\u00f1os<\/p><p>Cumplimos con los requisitos previos de COPPA (Ley de protecci\u00f3n de la privacidad en l\u00ednea de los ni\u00f1os), no recopilamos datos de personas menores de 13 a\u00f1os. Nuestro sitio, art\u00edculos y administraciones est\u00e1n completamente coordinados para personas que tienen al menos 13 a\u00f1os de edad o m\u00e1s establecidas.<\/p><p>Cambios a nuestra Pol\u00edtica de Privacidad<\/p><p>Si decidimos cambiar nuestra pol\u00edtica de privacidad, publicaremos esos cambios en esta p\u00e1gina.<\/p><p>\u00bfCu\u00e1nto tiempo retenemos su informaci\u00f3n?<\/p><p>En el momento en que se registra en nuestro sitio, ciclamos y mantenemos la informaci\u00f3n que tenemos sobre usted por el tiempo que no borre el registro o se retire (sujeto a leyes y pautas).<\/p>"}}}',
                'last_edit_by' => 1,
                'status' => 1,
                'created_at'   => now(),
                'updated_at' => now(),
              ],
            ];
            SetupPage::insert($data);

    }
}
