<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $data = array(

          'categories' => [
    [
        'title' => 'Digital Goods',
        'image' => str_replace('\\', '/', public_path('img/solutions/digital_goods.jpg')),
        'content' => 
            [
            'description' => '10 indicators of a love scam: A comprehensive checklist',
            'image' => str_replace('\\', '/', public_path('img/solutions/Digital_Goods/indicators.jpg')),
            'indicators' => [
                'description' => 'This comprehensive checklist is designed to assist individuals in identifying the various signs and indicators commonly associated with romance scams, thereby enhancing their ability to protect themselves from such fraudulent activities.',
                        'image' => str_replace('\\', '/', public_path('img/solutions/Digital_Goods/indicators.jpg'))
                    ]
            ],
                [
            'description' => 'Online fraud protection a practical guide',
            'image' => str_replace('\\', '/', public_path('img/solutions/Digital_Goods/online_fraud.jpg')),
            'indicators' => [
                'description' => 'This comprehensive checklist is designed to assist individuals in identifying the various signs and indicators commonly associated with romance scams, thereby enhancing their ability to protect themselves from such fraudulent activities.',
                        'image' => str_replace('\\', '/', public_path('img/solutions/Digital_Goods/online_fraud.jpg'))
                    ]

            ],

            [
                'description' => 'Printable fraud awareness workbook with exercises',
                'image' => str_replace('\\', '/', public_path('img/solutions/Digital_Goods/printable.jpg')),
                'indicators' => [
                    'description' => 'Enhance your fraud prevention skills with our Fraud Awareness Workbook. This comprehensive printable guide includes self-assessments, interactive exercises, and essential resources to help you identify and protect against scams. Perfect for boosting your online security and staying vigilant against fraud.',
                            'image' => str_replace('\\', '/', public_path('img/solutions/Digital_Goods/printable.jpg'))
                        ]
    
            ],


            ]
        ],


            [
                'title' => 'Cryptocurrency investigations and regulatory compliance',
                'image' => str_replace('\\', '/', public_path('img/solutions/Cryptocurrency.jpeg'))
            ],
            [
                'title' => 'Research and dispute resolution',
                'image' => str_replace('\\', '/', public_path('img/solutions/Investigation_Dispute.jpeg'))
            ],
            [
                'title' => 'Advisory and documentation assistance',
                'image' => str_replace('\\', '/', public_path('img/solutions/Consulting_Documental.jpeg'))
            ],
            [
                'title' => 'Corporate services',
                'image' => str_replace('\\', '/', public_path('img/solutions/Business_services.jpeg'))
            ],
        )
           


    ;
        
        return response()->json($data);
        
    }
}
