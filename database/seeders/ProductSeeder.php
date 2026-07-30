<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductSeeder extends Seeder
{
    /**
     * بيانات الفئات مع الصور والمنتجات
     */
    private array $categoriesData = [
        [
            'name' => ['en' => 'Electronics', 'ar' => 'الإلكترونيات'],
            'description' => [
                'en' => 'Latest electronic devices and gadgets',
                'ar' => 'أحدث الأجهزة الإلكترونية والأدوات'
            ],
            'image_url' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=400',
            'sub_categories' => [
                [
                    'name' => ['en' => 'Smartphones', 'ar' => 'الهواتف الذكية'],
                    'image_url' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400',
                    'products' => [
                        ['name' => ['en' => 'iPhone 15 Pro Max', 'ar' => 'آيفون 15 برو ماكس'], 'price' => 4999, 'stock' => 25, 'image' => 'https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=600', 'featured' => true],
                        ['name' => ['en' => 'Samsung Galaxy S24', 'ar' => 'سامسونج جالاكسي S24'], 'price' => 3799, 'stock' => 30, 'image' => 'https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=600', 'featured' => true],
                        ['name' => ['en' => 'Xiaomi 14 Pro', 'ar' => 'شاومي 14 برو'], 'price' => 2499, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=600', 'featured' => false],
                        ['name' => ['en' => 'Google Pixel 8', 'ar' => 'جوجل بكسل 8'], 'price' => 2999, 'stock' => 20, 'image' => 'https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?w=600', 'featured' => false],
                    ]
                ],
                [
                    'name' => ['en' => 'Laptops', 'ar' => 'اللابتوبات'],
                    'image_url' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400',
                    'products' => [
                        ['name' => ['en' => 'MacBook Pro M3', 'ar' => 'ماك بوك برو M3'], 'price' => 8999, 'stock' => 15, 'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600', 'featured' => true],
                        ['name' => ['en' => 'Dell XPS 15', 'ar' => 'ديل XPS 15'], 'price' => 6499, 'stock' => 18, 'image' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=600', 'featured' => false],
                        ['name' => ['en' => 'HP Spectre x360', 'ar' => 'إتش بي سبكتر'], 'price' => 5299, 'stock' => 12, 'image' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=600', 'featured' => false],
                        ['name' => ['en' => 'Lenovo ThinkPad', 'ar' => 'لينوفو ثينك باد'], 'price' => 4599, 'stock' => 22, 'image' => 'https://images.unsplash.com/photo-1525547719571-a2d4ac8945e2?w=600', 'featured' => true],
                    ]
                ],
                [
                    'name' => ['en' => 'Headphones', 'ar' => 'سماعات الرأس'],
                    'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400',
                    'products' => [
                        ['name' => ['en' => 'AirPods Pro 2', 'ar' => 'إيربودز برو 2'], 'price' => 999, 'stock' => 50, 'image' => 'https://images.unsplash.com/photo-1600294037683-c632f39592b3?w=600', 'featured' => true],
                        ['name' => ['en' => 'Sony WH-1000XM5', 'ar' => 'سوني WH-1000XM5'], 'price' => 1499, 'stock' => 35, 'image' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=600', 'featured' => true],
                        ['name' => ['en' => 'Bose QuietComfort', 'ar' => 'بوز كوايت كومفورت'], 'price' => 1299, 'stock' => 28, 'image' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=600', 'featured' => false],
                    ]
                ],
            ]
        ],
        [
            'name' => ['en' => 'Fashion', 'ar' => 'الأزياء'],
            'description' => [
                'en' => 'Trendy clothes and accessories',
                'ar' => 'ملابس وإكسسوارات عصرية'
            ],
            'image_url' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=400',
            'sub_categories' => [
                [
                    'name' => ['en' => "Men's Clothing", 'ar' => 'ملابس رجالية'],
                    'image_url' => 'https://images.unsplash.com/photo-1617137968427-85924c800a22?w=400',
                    'products' => [
                        ['name' => ['en' => 'Classic White Shirt', 'ar' => 'قميص أبيض كلاسيكي'], 'price' => 249, 'stock' => 60, 'image' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?w=600', 'featured' => true],
                        ['name' => ['en' => 'Denim Jacket', 'ar' => 'جاكيت جينز'], 'price' => 499, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600', 'featured' => false],
                        ['name' => ['en' => 'Casual T-Shirt', 'ar' => 'تيشيرت كاجوال'], 'price' => 129, 'stock' => 100, 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600', 'featured' => true],
                        ['name' => ['en' => 'Formal Suit', 'ar' => 'بدلة رسمية'], 'price' => 1299, 'stock' => 20, 'image' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=600', 'featured' => false],
                    ]
                ],
                [
                    'name' => ['en' => "Women's Clothing", 'ar' => 'ملابس نسائية'],
                    'image_url' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=400',
                    'products' => [
                        ['name' => ['en' => 'Elegant Dress', 'ar' => 'فستان أنيق'], 'price' => 599, 'stock' => 35, 'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=600', 'featured' => true],
                        ['name' => ['en' => 'Summer Blouse', 'ar' => 'بلوزة صيفية'], 'price' => 199, 'stock' => 55, 'image' => 'https://images.unsplash.com/photo-1564257577-2d3ee8740efc?w=600', 'featured' => false],
                        ['name' => ['en' => 'Designer Handbag', 'ar' => 'حقيبة يد مصممة'], 'price' => 899, 'stock' => 25, 'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=600', 'featured' => true],
                        ['name' => ['en' => 'High Heels', 'ar' => 'كعب عالي'], 'price' => 399, 'stock' => 30, 'image' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=600', 'featured' => false],
                    ]
                ],
                [
                    'name' => ['en' => 'Accessories', 'ar' => 'الإكسسوارات'],
                    'image_url' => 'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=400',
                    'products' => [
                        ['name' => ['en' => 'Luxury Watch', 'ar' => 'ساعة فاخرة'], 'price' => 2499, 'stock' => 15, 'image' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=600', 'featured' => true],
                        ['name' => ['en' => 'Leather Wallet', 'ar' => 'محفظة جلدية'], 'price' => 299, 'stock' => 45, 'image' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=600', 'featured' => false],
                        ['name' => ['en' => 'Sunglasses', 'ar' => 'نظارات شمسية'], 'price' => 449, 'stock' => 38, 'image' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=600', 'featured' => true],
                    ]
                ],
            ]
        ],
        [
            'name' => ['en' => 'Home & Kitchen', 'ar' => 'المنزل والمطبخ'],
            'description' => [
                'en' => 'Everything you need for your home',
                'ar' => 'كل ما تحتاجه لمنزلك'
            ],
            'image_url' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400',
            'sub_categories' => [
                [
                    'name' => ['en' => 'Furniture', 'ar' => 'الأثاث'],
                    'image_url' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=400',
                    'products' => [
                        ['name' => ['en' => 'Modern Sofa', 'ar' => 'أريكة عصرية'], 'price' => 3499, 'stock' => 10, 'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600', 'featured' => true],
                        ['name' => ['en' => 'Dining Table', 'ar' => 'طاولة طعام'], 'price' => 1999, 'stock' => 12, 'image' => 'https://images.unsplash.com/photo-1617806118233-18e1de247200?w=600', 'featured' => false],
                        ['name' => ['en' => 'Office Chair', 'ar' => 'كرسي مكتب'], 'price' => 899, 'stock' => 25, 'image' => 'https://images.unsplash.com/photo-1580480055273-228ff5388ef8?w=600', 'featured' => false],
                    ]
                ],
                [
                    'name' => ['en' => 'Kitchen Appliances', 'ar' => 'أجهزة المطبخ'],
                    'image_url' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400',
                    'products' => [
                        ['name' => ['en' => 'Coffee Maker', 'ar' => 'ماكينة قهوة'], 'price' => 799, 'stock' => 30, 'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600', 'featured' => true],
                        ['name' => ['en' => 'Blender', 'ar' => 'خلاط'], 'price' => 349, 'stock' => 45, 'image' => 'https://images.unsplash.com/photo-1570222094114-d054a817e56b?w=600', 'featured' => false],
                        ['name' => ['en' => 'Microwave Oven', 'ar' => 'فرن ميكروويف'], 'price' => 599, 'stock' => 20, 'image' => 'https://images.unsplash.com/photo-1574269909862-7e1d70bb8078?w=600', 'featured' => false],
                        ['name' => ['en' => 'Air Fryer', 'ar' => 'قلاية هوائية'], 'price' => 699, 'stock' => 28, 'image' => 'https://images.unsplash.com/photo-1585515320310-259814833e62?w=600', 'featured' => true],
                    ]
                ],
                [
                    'name' => ['en' => 'Home Decor', 'ar' => 'ديكور المنزل'],
                    'image_url' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=400',
                    'products' => [
                        ['name' => ['en' => 'Wall Painting', 'ar' => 'لوحة جدارية'], 'price' => 299, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=600', 'featured' => false],
                        ['name' => ['en' => 'Decorative Vase', 'ar' => 'مزهرية ديكورية'], 'price' => 179, 'stock' => 50, 'image' => 'https://images.unsplash.com/photo-1578500494198-246f612d3b3d?w=600', 'featured' => false],
                        ['name' => ['en' => 'Table Lamp', 'ar' => 'مصباح طاولة'], 'price' => 249, 'stock' => 35, 'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=600', 'featured' => true],
                    ]
                ],
            ]
        ],
        [
            'name' => ['en' => 'Sports & Outdoors', 'ar' => 'الرياضة والهواء الطلق'],
            'description' => [
                'en' => 'Sports equipment and outdoor gear',
                'ar' => 'معدات رياضية ومعدات الهواء الطلق'
            ],
            'image_url' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=400',
            'sub_categories' => [
                [
                    'name' => ['en' => 'Fitness Equipment', 'ar' => 'معدات اللياقة'],
                    'image_url' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400',
                    'products' => [
                        ['name' => ['en' => 'Treadmill', 'ar' => 'جهاز المشي'], 'price' => 2999, 'stock' => 10, 'image' => 'https://images.unsplash.com/photo-1576678927484-cc907957088c?w=600', 'featured' => true],
                        ['name' => ['en' => 'Dumbbells Set', 'ar' => 'مجموعة أوزان'], 'price' => 599, 'stock' => 25, 'image' => 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?w=600', 'featured' => false],
                        ['name' => ['en' => 'Yoga Mat', 'ar' => 'سجادة يوغا'], 'price' => 149, 'stock' => 60, 'image' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=600', 'featured' => false],
                        ['name' => ['en' => 'Exercise Bike', 'ar' => 'دراجة تمرين'], 'price' => 1799, 'stock' => 15, 'image' => 'https://images.unsplash.com/photo-1591741535018-d042766c62eb?w=600', 'featured' => true],
                    ]
                ],
                [
                    'name' => ['en' => 'Sportswear', 'ar' => 'الملابس الرياضية'],
                    'image_url' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400',
                    'products' => [
                        ['name' => ['en' => 'Running Shoes', 'ar' => 'حذاء جري'], 'price' => 449, 'stock' => 50, 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600', 'featured' => true],
                        ['name' => ['en' => 'Sports Jersey', 'ar' => 'قميص رياضي'], 'price' => 199, 'stock' => 70, 'image' => 'https://images.unsplash.com/photo-1580087256394-dc596e1c2f1a?w=600', 'featured' => false],
                        ['name' => ['en' => 'Sports Shorts', 'ar' => 'شورت رياضي'], 'price' => 129, 'stock' => 80, 'image' => 'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=600', 'featured' => false],
                    ]
                ],
                [
                    'name' => ['en' => 'Camping Gear', 'ar' => 'معدات التخييم'],
                    'image_url' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=400',
                    'products' => [
                        ['name' => ['en' => 'Camping Tent', 'ar' => 'خيمة تخييم'], 'price' => 899, 'stock' => 20, 'image' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=600', 'featured' => true],
                        ['name' => ['en' => 'Sleeping Bag', 'ar' => 'كيس نوم'], 'price' => 299, 'stock' => 35, 'image' => 'https://images.unsplash.com/photo-1520209759809-a9bcb6cb3241?w=600', 'featured' => false],
                        ['name' => ['en' => 'Hiking Backpack', 'ar' => 'حقيبة ظهر للمشي'], 'price' => 449, 'stock' => 28, 'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600', 'featured' => false],
                    ]
                ],
            ]
        ],
        [
            'name' => ['en' => 'Beauty & Health', 'ar' => 'الجمال والصحة'],
            'description' => [
                'en' => 'Cosmetics and personal care products',
                'ar' => 'مستحضرات التجميل والعناية الشخصية'
            ],
            'image_url' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400',
            'sub_categories' => [
                [
                    'name' => ['en' => 'Skincare', 'ar' => 'العناية بالبشرة'],
                    'image_url' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=400',
                    'products' => [
                        ['name' => ['en' => 'Face Moisturizer', 'ar' => 'مرطب الوجه'], 'price' => 179, 'stock' => 60, 'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600', 'featured' => true],
                        ['name' => ['en' => 'Vitamin C Serum', 'ar' => 'سيروم فيتامين سي'], 'price' => 249, 'stock' => 45, 'image' => 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=600', 'featured' => false],
                        ['name' => ['en' => 'Sunscreen SPF 50', 'ar' => 'واقي شمس'], 'price' => 129, 'stock' => 70, 'image' => 'https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?w=600', 'featured' => false],
                    ]
                ],
                [
                    'name' => ['en' => 'Makeup', 'ar' => 'المكياج'],
                    'image_url' => 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=400',
                    'products' => [
                        ['name' => ['en' => 'Foundation', 'ar' => 'كريم أساس'], 'price' => 199, 'stock' => 50, 'image' => 'https://images.unsplash.com/photo-1522335789203-aaa2f3042175?w=600', 'featured' => true],
                        ['name' => ['en' => 'Lipstick Set', 'ar' => 'مجموعة أحمر شفاه'], 'price' => 299, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=600', 'featured' => true],
                        ['name' => ['en' => 'Eyeshadow Palette', 'ar' => 'باليت ظلال العيون'], 'price' => 249, 'stock' => 35, 'image' => 'https://images.unsplash.com/photo-1583241800698-9c2e0c8f8c4f?w=600', 'featured' => false],
                        ['name' => ['en' => 'Mascara', 'ar' => 'ماسكارا'], 'price' => 99, 'stock' => 80, 'image' => 'https://images.unsplash.com/photo-1631214524020-7e18db9a8f92?w=600', 'featured' => false],
                    ]
                ],
                [
                    'name' => ['en' => 'Hair Care', 'ar' => 'العناية بالشعر'],
                    'image_url' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=400',
                    'products' => [
                        ['name' => ['en' => 'Shampoo', 'ar' => 'شامبو'], 'price' => 79, 'stock' => 100, 'image' => 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?w=600', 'featured' => false],
                        ['name' => ['en' => 'Hair Dryer', 'ar' => 'مجفف شعر'], 'price' => 399, 'stock' => 30, 'image' => 'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?w=600', 'featured' => true],
                        ['name' => ['en' => 'Hair Oil', 'ar' => 'زيت شعر'], 'price' => 149, 'stock' => 55, 'image' => 'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?w=600', 'featured' => false],
                    ]
                ],
            ]
        ],
        [
            'name' => ['en' => 'Books & Stationery', 'ar' => 'الكتب والقرطاسية'],
            'description' => [
                'en' => 'Books, notebooks and office supplies',
                'ar' => 'كتب ودفاتر ومستلزمات مكتبية'
            ],
            'image_url' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400',
            'sub_categories' => [
                [
                    'name' => ['en' => 'Books', 'ar' => 'الكتب'],
                    'image_url' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400',
                    'products' => [
                        ['name' => ['en' => 'Programming Guide', 'ar' => 'دليل البرمجة'], 'price' => 89, 'stock' => 50, 'image' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=600', 'featured' => true],
                        ['name' => ['en' => 'Novel Bestseller', 'ar' => 'رواية الأكثر مبيعاً'], 'price' => 59, 'stock' => 80, 'image' => 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=600', 'featured' => false],
                        ['name' => ['en' => 'Self-Help Book', 'ar' => 'كتاب تطوير الذات'], 'price' => 69, 'stock' => 65, 'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=600', 'featured' => false],
                    ]
                ],
                [
                    'name' => ['en' => 'Notebooks', 'ar' => 'الدفاتر'],
                    'image_url' => 'https://images.unsplash.com/photo-1531346878377-a5be20888e57?w=400',
                    'products' => [
                        ['name' => ['en' => 'Leather Notebook', 'ar' => 'دفتر جلد'], 'price' => 79, 'stock' => 60, 'image' => 'https://images.unsplash.com/photo-1531346878377-a5be20888e57?w=600', 'featured' => false],
                        ['name' => ['en' => 'Journal Planner', 'ar' => 'مخطط يومي'], 'price' => 49, 'stock' => 90, 'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=600', 'featured' => false],
                        ['name' => ['en' => 'Sketch Book', 'ar' => 'دفتر رسم'], 'price' => 39, 'stock' => 75, 'image' => 'https://images.unsplash.com/photo-1456735190827-d1262f71b8a3?w=600', 'featured' => true],
                    ]
                ],
                [
                    'name' => ['en' => 'Office Supplies', 'ar' => 'المستلزمات المكتبية'],
                    'image_url' => 'https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=400',
                    'products' => [
                        ['name' => ['en' => 'Pen Set', 'ar' => 'مجموعة أقلام'], 'price' => 59, 'stock' => 100, 'image' => 'https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?w=600', 'featured' => false],
                        ['name' => ['en' => 'Desk Organizer', 'ar' => 'منظم مكتب'], 'price' => 129, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1586281380349-632531db7ed4?w=600', 'featured' => false],
                        ['name' => ['en' => 'Sticky Notes Pack', 'ar' => 'مجموعة ملاحظات لاصقة'], 'price' => 29, 'stock' => 120, 'image' => 'https://images.unsplash.com/photo-1586075010923-2dd4570fb328?w=600', 'featured' => true],
                    ]
                ],
            ]
        ],
    ];

    public function run(): void
    {
        $this->command->info('🌱 Starting Product Data Seeder...');

        foreach ($this->categoriesData as $index => $categoryData) {
            $this->command->info("📁 Creating Category: {$categoryData['name']['en']}");

            // تنزيل صورة الفئة
            $categoryImagePath = $this->downloadImage(
                $categoryData['image_url'],
                'categories',
                Str::slug($categoryData['name']['en'])
            );

            // إنشاء الفئة
            $category = Category::create([
                'name' => json_encode($categoryData['name']),
                'description' => json_encode($categoryData['description']),
                'slug' => Str::slug($categoryData['name']['en']),
                'image' => $categoryImagePath,
                'is_active' => true,
                'sort_order' => $index,
            ]);

            // إنشاء الفئات الفرعية
            foreach ($categoryData['sub_categories'] as $subIndex => $subData) {
                $this->command->info("  🏷️  Creating SubCategory: {$subData['name']['en']}");

                $subImagePath = $this->downloadImage(
                    $subData['image_url'],
                    'subcategories',
                    Str::slug($subData['name']['en'])
                );

                $subCategory = SubCategory::create([
                    'category_id' => $category->id,
                    'name' => json_encode($subData['name']),
                    'description' => json_encode([
                        'en' => "{$subData['name']['en']} products",
                        'ar' => "منتجات {$subData['name']['ar']}"
                    ]),
                    'slug' => Str::slug($subData['name']['en']),
                    'image' => $subImagePath,
                    'is_active' => true,
                ]);

                // إنشاء المنتجات
                foreach ($subData['products'] as $productData) {
                    $this->command->info("    📦 Creating Product: {$productData['name']['en']}");

                    $productImagePath = $this->downloadImage(
                        $productData['image'],
                        'products',
                        Str::slug($productData['name']['en'])
                    );

                    Product::create([
                        'category_id' => $category->id,
                        'sub_category_id' => $subCategory->id,
                        'name' => json_encode($productData['name']),
                        'description' => json_encode([
                            'en' => "High quality {$productData['name']['en']} with premium features and excellent performance.",
                            'ar' => "{$productData['name']['ar']} عالي الجودة بميزات ممتازة وأداء رائع."
                        ]),
                        'short_description' => json_encode([
                            'en' => "Best {$productData['name']['en']} in its category",
                            'ar' => "أفضل {$productData['name']['ar']} في فئته"
                        ]),
                        'slug' => Str::slug($productData['name']['en']) . '-' . uniqid(),
                        'sku' => 'SKU-' . strtoupper(Str::random(8)),
                        'price' => $productData['price'],
                        'sale_price' => rand(0, 1) ? $productData['price'] * 0.85 : null, // خصم 15% عشوائي
                        'stock' => $productData['stock'],
                        'image' => $productImagePath,
                        'gallery' => $this->generateGallery($productData['image'], 3),
                        'is_featured' => $productData['featured'],
                        'is_active' => true,
                    ]);
                }
            }
        }

        $this->command->info('✅ Product Data Seeder completed successfully!');
        $this->command->info("📊 Total Categories: " . Category::count());
        $this->command->info("📊 Total SubCategories: " . SubCategory::count());
        $this->command->info("📊 Total Products: " . Product::count());
    }

    /**
     * تنزيل الصورة من الرابط وحفظها محلياً
     */
    private function downloadImage(string $url, string $folder, string $filename): ?string
    {
        try {
            // إنشاء المجلد إذا لم يكن موجوداً
            $path = public_path("storage/{$folder}");
            if (!file_exists($path)) {
                mkdir($path, 0775, true);
            }

            // اسم الملف
            $fileName = $filename . '-' . time() . '.jpg';
            $fullPath = "{$path}/{$fileName}";

            // تنزيل الصورة
            $imageContents = @file_get_contents($url);
            if ($imageContents === false) {
                throw new \Exception("Failed to download image");
            }

            file_put_contents($fullPath, $imageContents);

            return "{$folder}/{$fileName}";
        } catch (\Exception $e) {
            $this->command->warn("  ⚠️  Could not download image: {$e->getMessage()}");
            return null;
        }
    }

    /**
     * توليد صور للمعرض (gallery) من نفس الصورة بزوايا مختلفة
     */
    private function generateGallery(string $mainImage, int $count = 3): array
    {
        $gallery = [];
        for ($i = 1; $i <= $count; $i++) {
            // استخدام صور Unsplash مشابهة
            $gallery[] = $mainImage . "&sig={$i}";
        }
        return $gallery;
    }
}
