<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CommandExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('render_command', [$this, 'renderCommand'], ['is_safe' => ['html']]),
            new TwigFunction('render_age', [$this, 'renderAge'], ['is_safe' => ['html']]),
            new TwigFunction('render_role', [$this, 'renderRole'], ['is_safe' => ['html']]),
        ];
    }

    public function renderCommand(string $command): string
    {
        $mapping = [
            '1+2+3+4' => '<img src="../img/assets/moves/1+2+3+4.png" alt="1+2+3+4">',
            '1+2+3' => '<img src="../img/assets/moves/1+2+3.png" alt="1+2+3">',
            '1+2+4' => '<img src="../img/assets/moves/1+2+4.png" alt="1+2+4">',
            '1+3+4' => '<img src="../img/assets/moves/1+3+4.png" alt="1+3+4">',
            '2+3+4' => '<img src="../img/assets/moves/2+3+4.png" alt="2+3+4">',
            '1+2' => '<img src="../img/assets/moves/1+2.png" alt="1+2">',
            '1+3' => '<img src="../img/assets/moves/1+3.png" alt="1+3">',
            '1+4' => '<img src="../img/assets/moves/1+4.png" alt="1+4">',
            '2+2' => '<img src="../img/assets/moves/2+2.png" alt="2+2">',
            '2+3' => '<img src="../img/assets/moves/2+3.png" alt="2+3">',
            '2+4' => '<img src="../img/assets/moves/2+4.png" alt="2+4">',
            '3+4' => '<img src="../img/assets/moves/3+4.png" alt="3+4">',
            'd/f' => '<img src="../img/assets/moves/df.png" alt="d/f">',
            'd/b' => '<img src="../img/assets/moves/db.png" alt="d/b">',
            'u/f' => '<img src="../img/assets/moves/uf.png" alt="u/f">',
            'u/b' => '<img src="../img/assets/moves/ub.png" alt="u/b">',
            '+1' => '<img src="../img/assets/moves/1.png" alt="1">',
            '+2' => '<img src="../img/assets/moves/2.png" alt="2">',
            '+3' => '<img src="../img/assets/moves/3.png" alt="3">',
            '+4' => '<img src="../img/assets/moves/4.png" alt="4">',
            '1' => '<img src="../img/assets/moves/1.png" alt="1">',
            '2' => '<img src="../img/assets/moves/2.png" alt="2">',
            '3' => '<img src="../img/assets/moves/3.png" alt="3">',
            '4' => '<img src="../img/assets/moves/4.png" alt="4">',
            'b' => '<img src="../img/assets/moves/b.png" alt="b">',
            'd' => '<img src="../img/assets/moves/d.png" alt="d">',
            'f' => '<img src="../img/assets/moves/f.png" alt="f">',
            'u' => '<img src="../img/assets/moves/u.png" alt="u">',
            'n' => '<img src="../img/assets/moves/n.png" alt="n">',
            '[' => '<img src="../img/assets/moves/[.png" alt="[">',
            ']' => '<img src="../img/assets/moves/].png" alt="]">',
            
        ];

        // Échappement des clés avant utilisation
        $escapedMapping = array_combine(
            array_map(fn($key) => preg_quote($key, '/'), array_keys($mapping)),
            $mapping
        );

        // Crée une expression régulière pour détecter toutes les commandes
        $pattern = '#' . implode('|', array_map('preg_quote', array_keys($mapping))) . '#';

        return preg_replace_callback($pattern, function ($matches) use ($mapping) {
            return $mapping[$matches[0]];
        }, $command);
        
    }

    public function renderAge(string $age): string
    {
        $mapping = [
            '404' => 'Inconnu',
            
        ];

        // Crée une expression régulière pour détecter toutes les commandes
        $pattern = '#' . implode('|', array_map('preg_quote', array_keys($mapping))) . '#';

        return preg_replace_callback($pattern, function ($matches) use ($mapping) {
            return $mapping[$matches[0]];
        }, $age);
        
    }

    public function renderRole(string $role): string
    {
        $mapping = [
            'ROLE_USER' => 'Membre',
            'ROLE_ADMIN' => 'Administrateur',
            
        ];

        // Crée une expression régulière pour détecter toutes les commandes
        $pattern = '#' . implode('|', array_map('preg_quote', array_keys($mapping))) . '#';

        return preg_replace_callback($pattern, function ($matches) use ($mapping) {
            return $mapping[$matches[0]];
        }, $role);
        
    }
}