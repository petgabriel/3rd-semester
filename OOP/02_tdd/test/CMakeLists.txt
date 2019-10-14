set(GOOGLETEST ../../googletest)

include_directories(${GOOGLETEST}/googletest/include)
link_directories(${GOOGLETEST}/build/lib)

set(TEST_HEADERS include/TestIncludes.h)
set(TEST_SOURCES src/RingBufferTest.cpp)

add_executable(02_tdd_test ${TEST_HEADERS} ${TEST_SOURCES})
target_include_directories(02_tdd_test PUBLIC include)
target_link_libraries(02_tdd_test 02_tdd_lib gtest gtest_main pthread)
