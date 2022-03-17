<?php

namespace Tests\Unit;

use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;

/**
 * Class ContactControllerTest
 * @package tests\Unit\Http\Controllers
 * @group uex
 */
class ContactTypeControllerTest extends TestCase {
    protected function setUp(): void {
        parent::setUp();
    }
    
    public function testIndex() {        
        $result = $this->get('/api/contact-types');
        $this->assertEquals(200, $result->status());
    }
}