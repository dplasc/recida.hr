<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomType;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        // Dohvati sve aktivne tipove imenika
        $customTypes = CustomType::where('status', 1)->orderBy('sorting', 'asc')->get();
        
        // Osnovni URL
        $baseUrl = url('/');
        
        // Počni s XML headerom i urlset tagom
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Statične stranice
        $staticPages = [
            '/' => '1.0',
            '/about-us' => '0.8',
            '/contact-us' => '0.8',
            '/blogs' => '0.9',
        ];
        
        foreach ($staticPages as $path => $priority) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . $path) . "</loc>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>" . $priority . "</priority>\n";
            $xml .= "  </url>\n";
        }
        
        // Dodaj linkove za svaku kategoriju (Directory Type)
        foreach ($customTypes as $type) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . '/listing/' . $type->slug . '/grid') . "</loc>\n";
            $xml .= "    <changefreq>daily</changefreq>\n";
            $xml .= "    <priority>0.9</priority>\n";
            $xml .= "  </url>\n";
        }
        
        // Zatvori urlset tag
        $xml .= '</urlset>';
        
        // Vrati XML response
        return response($xml, 200)
            ->header('Content-Type', 'text/xml; charset=utf-8');
    }
}