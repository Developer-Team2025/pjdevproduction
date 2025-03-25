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
            'description' => 'Explore our range of digital products designed to enhance your knowledge and skills in fraud prevention and online security. Our offerings include comprehensive workbooks, detailed self-assessments, interactive exercises, and curated resources that provide valuable insights and practical tools for staying vigilant against scams. Each product is crafted to help you improve your fraud detection capabilities, implement effective security practices, and stay informed about the latest fraud prevention techniques. Perfect for individuals and professionals looking to boost their cybersecurity measures and protect themselves from fraudulent activities.',
            'items' => [
                'description' => '10 Indicators of a Love Scam: A Comprehensive Checklist',
                'image' => str_replace('\\', '/', public_path('img/solutions/Digital_Goods/indicators.jpg')),
                 'description' => 'This comprehensive checklist is designed to assist individuals in identifying the various signs and indicators commonly associated with romance scams, thereby enhancing their ability to protect themselves from such fraudulent activities.
                                Stay safe in the digital dating world with our “10 Signs to Spot a Love Scam Checklist.” This comprehensive 5-page guide helps you recognize the warning signs of romance scams, providing practical tips and real-world examples. Whether you’re an online dater, concerned family member, or educator, this checklist equips you with the knowledge to protect yourself and your loved ones from deceitful predators. Learn to identify common scam tactics and take proactive steps to secure your personal information and finances. Download now and ensure your online interactions remain safe and genuine'
                    ]
            ],
                [
                    'title' => 'Online Fraud Protection: A Practical Guide',
                    'image' => str_replace('\\', '/', public_path('img/solutions/Digital_Goods/online_fraud.jpg')),
                    'description' => 'A comprehensive guide offering practical tips and strategies to protect yourself from online scams. Ideal for enhancing your scam awareness and online security.
                        Introducing “How Not to Get Scammed: A Guide to Protecting Yourself Online,” your ultimate resource for fraud prevention. This 25-page guide provides practical tips and strategies to help you recognize and avoid various online scams. With detailed chapters on identifying scams, protecting personal information, and reporting fraudulent activities, this guide equips you with the knowledge to stay safe online. Learn about phishing, tech support scams, investment frauds, and more, while implementing effective security measures to safeguard your digital life.'

            ],

            [

                'title' => 'Printable Fraud Awareness Workbook with Exercises',
                            'image' => str_replace('\\', '/', public_path('img/solutions/Digital_Goods/workbook.jpg')),
                            'description' => 'Enhance your fraud prevention skills with our Fraud Awareness Workbook. This comprehensive printable guide includes self-assessments, interactive exercises, and essential resources to help you identify and protect against scams. Perfect for boosting your online security and staying vigilant against fraud.
                                            Happy to present you the Fraud Awareness Workbook, your comprehensive guide to mastering fraud prevention and online security. This printable workbook is designed to enhance your scam awareness and equip you with the tools needed to protect yourself from various fraudulent activities. Whether you’re new to fraud prevention or looking to refine your skills, this workbook offers valuable insights and practical exercises to help you stay vigilant.
                            Features:
                                    Self-Assessments: Start and end your journey with detailed self-assessments to measure your initial understanding and track your progress in fraud awareness. These assessments provide a clear baseline and highlight areas for improvement.
                                    Masterclass & Presentation: Dive deep into the world of fraud prevention with our expertly crafted masterclass and comprehensive presentation materials. Learn about the latest fraud detection techniques and strategies to stay ahead of scammers.
                                    Interactive Exercises: Engage in practical exercises designed to enhance your ability to identify and respond to various fraud scenarios, including phishing emails, romance scams, and investment frauds. These activities reinforce your knowledge and boost your confidence in handling real-life situations.
                                    Checklists & Trackers: Utilize our practical checklists and trackers to maintain and improve your security practices. These tools help you stay organized, monitor your progress, and ensure consistent vigilance against fraud.
                                    Resources & Materials: Access a curated collection of essential resources and educational materials to support your ongoing learning. Stay informed about the latest fraud prevention tactics and protective measures with our up-to-date resources.
                                    Key Benefits:
                                                Enhanced Fraud Awareness: Improve your understanding of common fraud tactics and learn how to recognize potential scams.
                                                Effective Security Practices: Implement advanced security measures for your online accounts and personal information.
                                                Practical Skills: Gain hands-on experience through interactive exercises that prepare you for real-life fraud scenarios.
                                                Ongoing Support: Stay informed with access to the latest fraud prevention resources and materials.
                                                By completing the Fraud Awareness Workbook, you’ll develop the confidence and skills needed to safeguard yourself and your assets from potential scams. This workbook is perfect for individuals looking to improve their online security and fraud detection capabilities. Print it out, mark your progress, and take proactive steps to protect yourself from fraud with our detailed and practical guide.
                                                Boost your fraud prevention capabilities today with the Fraud Awareness Workbook—your ultimate resource for scam prevention and online security'                 
             ],

             [

                'title' => 'Fraud awareness masterclass with detailed presentation',
                            'image' => str_replace('\\', '/', public_path('img/solutions/Digital_Goods/masterclass.jpg')),
                            'description' => 'AUnlock the Secrets to Protecting Your Finances with Our Fraud Awareness Bundle
                                              In an era dominated by digital transactions, safeguarding against financial fraud is crucial. With cybercrime damages projected to cost the global economy $10.5 trillion annually by 2025, understanding fraud prevention is more vital than ever. Our comprehensive Fraud Awareness Bundle equips you with crucial tools and knowledge through a meticulously designed, recorded Masterclass and a comprehensive presentation PDF.'                  
             ],


      ]
        ],


            [
                'title' => 'Cryptocurrency Investigations and Regulatory Compliance',
                'image' => str_replace('\\', '/', public_path('img/solutions/cryptocurrency.jpg')),
                'content' => [
                    'description' => 'Cryptome Consulting excels in cryptocurrency compliance and investigation services. We help businesses, individuals, and law enforcement agencies navigate the complex digital asset landscape. Our expertise lies in probing digital asset cases, tracing cryptocurrencies, and analyzing blockchain transactions. We identify, locate, and trace funds involved in hacks, frauds, and scams across blockchain networks. Count on us to connect digital funds to real-world entities and obtain crucial evidence for your case.',
                    'sections' => [
                        [
                            'title' => 'Asset Location and Tracing Services',
                            'items' => [
                                [
                                    'title' => 'Business-Focused Cryptocurrency Intelligence Report',
                                    'image' => str_replace('\\', '/', public_path('img/solutions/cryptocurrency/asset_solution.jpg')),
                                    'description' => 'Comprehensive intelligence reports tailored for businesses dealing with cryptocurrency transactions.'
                                ],
                                [
                                    'title' => 'Cryptocurrency Transaction Risk Analysis',
                                    'image' => str_replace('\\', '/', public_path('img/solutions/cryptocurrency/Analysis_crypto.jpg')),
                                    'description' => 'Detailed analysis of cryptocurrency transactions to identify potential risks and red flags.'
                                ],
                                [
                                    'title' => 'Expert Cryptocurrency Witness Services',
                                    'image' => str_replace('\\', '/', public_path('img/solutions/cryptocurrency/Analysis_crypto.jpg')),
                                    'description' => 'Detailed analysis of cryptocurrency transactions to identify potential risks and red flags.'
                                ],
                                [
                                    'title' => 'Business-Focused Cryptocurrency Intelligence Report',
                                    'image' => str_replace('\\', '/', public_path('img/solutions/cryptocurrency/business_focused.jpg')),
                                    'description' => 'Detailed analysis of cryptocurrency transactions to identify potential risks and red flags.'
                                ],
                                [
                                    'title' => 'In-Depth Cryptocurrency Investigation Services',
                                    'image' => str_replace('\\', '/', public_path('img/solutions/Cryptocurrency/in_depthCrypto.jpg')),
                                    'description' => 'Thorough investigative services for complex cryptocurrency-related cases.'
                                ],
                                [
                                    'title' => 'General Cryptocurrency Intelligence Reports',
                                    'image' => str_replace('\\', '/', public_path('img/solutions/Cryptocurrency/Intelligence_report.jpg')),
                                    'description' => 'Standardized reports providing insights into cryptocurrency activities and trends.'
                                ],
                                [
                                    'title' => 'Support for cryptocurrency data collection',
                                    'image' => str_replace('\\', '/', public_path('img/solutions/Cryptocurrency/Data_Collection.jpg')),
                                    'description' => 'Standardized reports providing insights into cryptocurrency activities and trends.'
                                ]
                            ]
                        ],
                        [
                            'title' => 'Expert Cryptocurrency Witness Services',
                            'items' => [
                                [
                                    'title' => 'Expert Witness Testimony',
                                    'image' => str_replace('\\', '/', public_path('img/solutions/Cryptocurrency/expert_witness.jpg')),
                                    'description' => 'Professional testimony from cryptocurrency experts for legal proceedings.'
                                ],
                                [
                                    'title' => 'Forensic Analysis Presentation',
                                    'image' => str_replace('\\', '/', public_path('img/solutions/Cryptocurrency/forensic.jpg')),
                                    'description' => 'Clear presentation of forensic cryptocurrency analysis findings for court cases.'
                                ]
                            ]
                        ]
                    ]
                ]
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
