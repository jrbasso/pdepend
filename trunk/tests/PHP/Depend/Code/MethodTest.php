<?php
/**
 * This file is part of PHP_Depend.
 * 
 * PHP Version 5
 *
 * Copyright (c) 2008, Manuel Pichler <mapi@pmanuel-pichler.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  QualityAssurance
 * @package   PHP_Depend
 * @author    Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright 2008 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://www.manuel-pichler.de/
 */

require_once dirname(__FILE__) . '/AbstractDependencyTest.php';
require_once dirname(__FILE__) . '/TestNodeVisitor.php';

require_once 'PHP/Depend/Code/Method.php';

/**
 * Test case implementation for the PHP_Depend_Code_Method class.
 *
 * @category  QualityAssurance
 * @package   PHP_Depend
 * @author    Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright 2008 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: @package_version@
 * @link      http://www.manuel-pichler.de/
 */
class PHP_Depend_Code_MethodTest extends PHP_Depend_Code_AbstractDependencyTest
{
    /**
     * Tests the ctor and the {@link PHP_Depend_Code_Method::getName()} method.
     *
     * @return void
     */
    public function testCreateNewMethodInstance()
    {
        $method = new PHP_Depend_Code_Method('method', 0);
        $this->assertEquals('method', $method->getName());
    }
    
    /**
     * Tests that the {@link PHP_Depend_Code_Method::getParent()} returns as
     * default value <b>null</b> and that the package could be set and unset.
     *
     * @return void
     */
    public function testGetSetParent()
    {
        $class  = new PHP_Depend_Code_Class('clazz', 0, 'clazz.php');
        $method = new PHP_Depend_Code_Method('method', 0);
        
        $this->assertNull($method->getParent());
        $method->setParent($class);
        $this->assertSame($class, $method->getParent());
        $method->setParent(null);
        $this->assertNull($method->getParent());
    }
    
    /**
     * Tests the visitor accept method.
     *
     * @return void
     */
    public function testVisitorAccept()
    {
        $method  = new PHP_Depend_Code_Method('method', 0);
        $visitor = new PHP_Depend_Code_TestNodeVisitor();
        
        $this->assertNull($visitor->method);
        $method->accept($visitor);
        $this->assertSame($method, $visitor->method);
    }
    
    /**
     * Tests that the {@link PHP_Depend_Code_Method::setVisibility()} method
     * fails with an exception for an invalid visibility type.
     *
     * @return void
     */
    public function testSetInvalidVisibilityFail()
    {
        $this->setExpectedException('InvalidArgumentException');
        
        $method = new PHP_Depend_Code_Method('method');
        $method->setVisibility(0);
    }
    
    /**
     * Tests that the {@link PHP_Depend_Code_Method::setVisibility()} method
     * accepts the defined visibility value.
     *
     * @return void
     */
    public function testSetVisibilityAcceptsPublicValue()
    {
        $method = new PHP_Depend_Code_Method('method');
        $method->setVisibility(PHP_Depend_Code_VisibilityAwareI::IS_PUBLIC);
        $this->assertTrue($method->isPublic());
        $this->assertFalse($method->isProtected());
        $this->assertFalse($method->isPrivate());
    }
    
    /**
     * Tests that the {@link PHP_Depend_Code_Method::setVisibility()} method
     * accepts the defined visibility value.
     *
     * @return void
     */
    public function testSetVisibilityAcceptsProtectedValue()
    {
        $method = new PHP_Depend_Code_Method('method');
        $method->setVisibility(PHP_Depend_Code_VisibilityAwareI::IS_PROTECTED);
        $this->assertTrue($method->isProtected());
        $this->assertFalse($method->isPublic());
        $this->assertFalse($method->isPrivate());
    }
    
    /**
     * Tests that the {@link PHP_Depend_Code_Method::setVisibility()} method
     * accepts the defined visibility value.
     *
     * @return void
     */
    public function testSetVisibilityAcceptsPrivateValue()
    {
        $method = new PHP_Depend_Code_Method('method');
        $method->setVisibility(PHP_Depend_Code_VisibilityAwareI::IS_PRIVATE);
        $this->assertTrue($method->isPrivate());
        $this->assertFalse($method->isPublic());
        $this->assertFalse($method->isProtected());
    }
    
    /**
     * Tests that the {@link PHP_Depend_Code_Method::setVisibility()} method
     * ignores repeated calls if the internal value is set.
     *
     * @return void
     */
    public function testSetVisibilityOnlyAcceptsTheFirstValue()
    {
        $method = new PHP_Depend_Code_Method('method');
        $this->assertFalse($method->isPublic());
        $method->setVisibility(PHP_Depend_Code_VisibilityAwareI::IS_PUBLIC);
        $this->assertTrue($method->isPublic());
        $method->setVisibility(PHP_Depend_Code_VisibilityAwareI::IS_PROTECTED);
        $this->assertTrue($method->isPublic());
    }
    
    /**
     * Creates an abstract item instance.
     *
     * @return PHP_Depend_Code_AbstractItem
     */
    protected function createItem()
    {
        return new PHP_Depend_Code_Method('method', 0);
    }
    
    /**
     * Generates a node instance that can handle dependencies.
     *
     * @return PHP_Depend_Code_DependencyNode
     */
    protected function createDependencyNode()
    {
        return new PHP_Depend_Code_Method('method', 0);
    }
}