<?php

namespace Database\Seeders;

use Carbon\Traits\Timestamp;
use DateTime;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PageModel;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [[
            'name' => 'Home',
            'content' => '<div class="p-2">
                            <h1>Studiereizen 3de opleidingsfase Professionele Bachelor</h1>
                            <p>Reeds vele jaren neemt internationalisering een prominente plaats in bij de Professionele Bachelors Elektromechanica, Energietechnologie en Elektronica-ICT. We vinden het immers belangrijk dat studenten tijdens hun opleiding in contact komen met buitenlandse industrie, onderwijs en cultuur. Met het oog op een latere loopbaan en zeker in het Europa van vandaag, is het eveneens niet onbelangrijk dat je jezelf leert uitdrukken in een andere taal. Internationalisering maakt deel uit van de opleiding tot Professionele Bachelor, en behoort dus tot het verplichte curriculum.</p>
                            <p>Dit jaar maken we een rondreis van een week in Duitsland en Tsjechië.</p>
                            <ul>
                                <li>Vertrek: <strong>Zondag 18&nbsp;mei 2025</strong></li>
                                <li>Terug in Diepenbeek: <strong>Zondag&nbsp;25&nbsp;mei 2025</strong></li>
                                <li>18&nbsp;/ 22 mei <strong>München</strong></li>
                                <li>22&nbsp;/ &nbsp;25&nbsp;mei <strong>Praag</strong></li>
                            </ul>
                            <p>We zijn met ongeveer 100&nbsp;studenten en 4 docenten.</p>
                            <p>Het programma wordt momenteel geconcretiseerd. De volgende activiteiten zijn al voorzien:</p>
                            <ul>
                                <li>Een bezoek aan het concentratiekamp Dachau</li>
                                <li>Een bezoek aan Airbus helikopters</li>
                                <li>Een begeleide fietstocht door het centrum van München</li>
                                <li>Een bezoek aan de brouwerij Erdinger</li>
                                <li>Een bezoek aan het Deutsches Museum (wetenschap en technologie)</li>
                                <li>Een wandeling door het historisch centrum van Pilsen</li>
                                <li>Een bezoek aan de Skoda autofabriek en het museum</li>
                                <li>Een begeleide wandeling door het historisch centrum van Praag.</li>
                            </ul>
                            <p>Tijdens deze reis maak je kennis met&nbsp;de belangrijkste highlights van München en Praag&nbsp;en bezoeken we een aantal bedrijven in de buurt voor een technische rondleiding. Er zijn ook een aantal vrije momenten voorzien om een eigen invulling te geven aan deze reis.&nbsp;</p>
                            <ul>
                            </ul>
                        </div>',
            'access_level'=> "admin,guide,traveller,guest",
            'type' => 'html',
            'routename' => 'home'
        ],
        [
            'name' => 'Voorbeeldreis',
            'content' => 'http://localhost/storage/files/1/BeperktProgrammaDuitslandTsjechieWebsite.pdf',
            'access_level' => "admin,guide,traveller,guest",
            'type' => "pdf",
            'routename' => "voorbeeldreizen"
        ],
        [
            'name' => 'Contact',
            'content' => 'Hello',
            'access_level' => "admin,guide,traveller,guest",
            'type' => "html",
            'routename' => 'contact'
        ]];
        foreach($pages as $page){
           PageModel::create($page);
        }
    }
}
