cmake_minimum_required(VERSION 3.13.4)
project(01_cmake)

set(CMAKE_CXX_STANDARD 17)

include_directories(../googletest/googletest/include)
link_directories(../googletest/build/lib)

add_library(dummy runner/dummy.cpp)
include_directories(dummy)

add_executable(runner runner/runner.cpp)
target_link_libraries(runner dummy)

add_executable(run_test test/test.cpp)
target_link_libraries(run_test gtest gtest_main pthread dummy)
