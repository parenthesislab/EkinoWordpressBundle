<?php
/*
 * This file is part of the Parenthesis Wordpress package.
 *
 * (c) 2013 Parenthesis
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parenthesis\WPBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration.
 *
 * This class generates configuration settings tree
 *
 * @author Vincent Composieux <composieux@ekino.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Builds configuration tree.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder A tree builder instance
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('parenthesis_wp');

        $rootNode
            ->children()
                ->scalarNode('table_prefix')->end()
                ->scalarNode('wordpress_directory')->defaultNull()->end()
                ->scalarNode('entity_manager')->end()
                ->booleanNode('load_twig_extension')->defaultFalse()->end()
                ->booleanNode('cookie_hash')->defaultNull()->end()
                ->scalarNode('i18n_cookie_name')->defaultFalse()->end()
                ->booleanNode('enable_wordpress_listener')->defaultTrue()->end()

                ->arrayNode('globals')
                    ->prototype('scalar')->defaultValue([])->end()
                ->end()

                ->arrayNode('security')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('firewall_name')->defaultValue('secured_area')->end()
                        ->scalarNode('login_url')->defaultValue('/wp-login.php')->end()
                    ->end()
                ->end()
            ->end();

        $this->addServicesSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    protected function addServicesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('services')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('comment')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Entity\Comment')->end()
                            ->scalarNode('manager')->cannotBeEmpty()->defaultValue('parenthesis.wp.manager.comment_default')->end()
                            ->scalarNode('repository_class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Repository\CommentRepository')->end()
                        ->end()
                    ->end()
                    ->arrayNode('comment_meta')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Entity\CommentMeta')->end()
                            ->scalarNode('manager')->cannotBeEmpty()->defaultValue('parenthesis.wp.manager.comment_meta_default')->end()
                            ->scalarNode('repository_class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Repository\CommentMetaRepository')->end()
                        ->end()
                    ->end()
                    ->arrayNode('link')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Entity\Link')->end()
                            ->scalarNode('manager')->cannotBeEmpty()->defaultValue('parenthesis.wp.manager.link_default')->end()
                            ->scalarNode('repository_class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Repository\LinkRepository')->end()
                        ->end()
                    ->end()
                    ->arrayNode('option')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Entity\Option')->end()
                            ->scalarNode('manager')->cannotBeEmpty()->defaultValue('parenthesis.wp.manager.option_default')->end()
                            ->scalarNode('repository_class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Repository\OptionRepository')->end()
                        ->end()
                    ->end()
                    ->arrayNode('post')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Entity\Post')->end()
                            ->scalarNode('manager')->cannotBeEmpty()->defaultValue('parenthesis.wp.manager.post_default')->end()
                            ->scalarNode('repository_class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Repository\PostRepository')->end()
                        ->end()
                    ->end()
                    ->arrayNode('post_meta')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Entity\PostMeta')->end()
                            ->scalarNode('manager')->cannotBeEmpty()->defaultValue('parenthesis.wp.manager.post_meta_default')->end()
                            ->scalarNode('repository_class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Repository\PostMetaRepository')->end()
                        ->end()
                    ->end()
                    ->arrayNode('term')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Entity\Term')->end()
                            ->scalarNode('manager')->cannotBeEmpty()->defaultValue('parenthesis.wp.manager.term_default')->end()
                            ->scalarNode('repository_class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Repository\TermRepository')->end()
                        ->end()
                    ->end()
                    ->arrayNode('term_relationships')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Entity\TermRelationships')->end()
                            ->scalarNode('manager')->cannotBeEmpty()->defaultValue('parenthesis.wp.manager.term_relationships_default')->end()
                            ->scalarNode('repository_class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Repository\TermRelationshipsRepository')->end()
                        ->end()
                    ->end()
                    ->arrayNode('term_taxonomy')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Entity\TermTaxonomy')->end()
                            ->scalarNode('manager')->cannotBeEmpty()->defaultValue('parenthesis.wp.manager.term_taxonomy_default')->end()
                            ->scalarNode('repository_class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Repository\TermTaxonomyRepository')->end()
                        ->end()
                    ->end()
                    ->arrayNode('user')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Entity\User')->end()
                            ->scalarNode('manager')->cannotBeEmpty()->defaultValue('parenthesis.wp.manager.user_default')->end()
                            ->scalarNode('repository_class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Repository\UserRepository')->end()
                        ->end()
                    ->end()
                    ->arrayNode('user_meta')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Entity\UserMeta')->end()
                            ->scalarNode('manager')->cannotBeEmpty()->defaultValue('parenthesis.wp.manager.user_meta_default')->end()
                            ->scalarNode('repository_class')->cannotBeEmpty()->defaultValue('Parenthesis\WPBundle\Repository\UserMetaRepository')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
