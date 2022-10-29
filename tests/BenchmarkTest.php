<?php

use markhuot\craftpest\factories\Entry;
use markhuot\craftpest\factories\Section;

it('benchmarks duplicate queries')
    ->beginBenchmark()
    ->get('/')
    ->assertOk()
    ->endBenchmark()
    ->assertNoDuplicateQueries();

it('benchmarks query speed')
    ->beginBenchmark()
    ->get('/')
    ->assertOk()
    ->endBenchmark()
    ->assertAllQueriesFasterThan(0.5);

it('benchmarks load time')
    ->beginBenchmark()
    ->get('/')
    ->assertOk()
    ->endBenchmark()
    ->assertLoadTimeLessThan(2);

it('benchmarks memory usage')
    ->beginBenchmark()
    ->get('/')
    ->assertOk()
    ->endBenchmark()
    ->assertMemoryLoadLessThan(256);
