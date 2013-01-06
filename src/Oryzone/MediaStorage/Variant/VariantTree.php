<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\Variant;

use Oryzone\MediaStorage\Exception\InvalidArgumentException;

/**
 * Tree structure to process variants following a hierarchical logic
 */
class VariantTree implements \IteratorAggregate
{

    protected $root;

    protected $nodes;

    /**
     * Constructor. Build a new tree
     *
     * @param VariantInterface $root
     */
    public function __construct(VariantInterface $root = NULL)
    {
        $this->nodes = array();
        if($root !== NULL)
            $this->add($root);
    }

    /**
     * Gets the root node
     *
     * @return VariantNode
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Adds a variant (automatically creates a node with a given variant and adds it to the tree)
     *
     * @param  VariantInterface $content
     * @param  string|null      $parentName
     * @throws \Oryzone\MediaStorage\Exception\InvalidArgumentException if new node contains a variant with no name or
     * an already declared name
     * @return VariantNode
     */
    public function add(VariantInterface $content, $parentName = NULL)
    {
        $node = new VariantNode($content);
        if ($parentName) {
            $parent = $this->getNode($parentName);
            $node->setParent($parent);
            $parent->addChild($node);
        } else {
            if($this->root !== NULL)
                throw new InvalidArgumentException('You tried to add a node as root (because you gave a NULL $parentName) but a root node is already present');
            $this->root = $node;
        }
        if($content->getName() == "")
            throw new InvalidArgumentException('A variant with no name can\'t be added to the tree');
        if(isset($this->nodes[$content->getName()]))
            throw new InvalidArgumentException(sprintf('A variant with the name "%s" has already been added to the tree', $content->getName()));

        $this->nodes[$content->getName()] = $node;

        return $node;
    }

    /**
     * Gets a node with a given name
     *
     * @param $name
     * @return mixed
     * @throws \Oryzone\MediaStorage\Exception\InvalidArgumentException
     */
    public function getNode($name)
    {
        if(!isset($this->nodes[$name]))
            throw new InvalidArgumentException(sprintf('Cannot find node named "%s" in variant tree', $name));

        return $this->nodes[$name];
    }

    /**
     * Performs a Depth First Visit on the tree calling a function on each node of the visit.
     * The function is called with the current node and the current level
     *
     * @param callable $function
     */
    public function visit(\Closure $function)
    {
        $this->visit_recursive($this->root, $function);
    }

    /**
     * Starts a depth first visit (recursive)
     */
    protected function visitForIterator()
    {
        $visit = array();
        $this->visit(function(VariantNode $node, $level) use (&$visit) {
            $visit[] = $node->getContent();
        });

        return $visit;
    }

    /**
     * Performs recursive visit from a node
     *
     * @param VariantNode $node
     * @param callable $function
     * @param int $level
     * @return void
     */
    protected function visit_recursive(VariantNode $node, \Closure $function = NULL, $level = 0)
    {
        if ($node !== NULL) {
            if($function)
                $function($node, $level);
            foreach($node->getChildren() as $child)
                $this->visit_recursive($child, $function, $level +1);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->visitForIterator());
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        // used for debug
        return $this->__toStringRecursive($this->root);
    }

    protected function __toStringRecursive(VariantNode $node, $level = 0, $string = '')
    {
        if ($node !== NULL) {
            if(!empty($string))
                $string .= "\n";
            for($i = 0; $i < $level; $i++)
                $string .= "\t";
            $string .= $node->getContent()->getName();

            foreach($node->getChildren() as $child)
                $string = $this->__toStringRecursive($child, $level + 1, $string);
        }

        return $string;
    }

}