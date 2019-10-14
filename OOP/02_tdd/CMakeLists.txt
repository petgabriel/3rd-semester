cmake_minimum_required(VERSION 3.10)
project(02_tdd)

set(HEADERS include/RingBuffer.h)
set(SOURCES src/RingBuffer.cpp)

add_library(02_tdd_lib ${HEADERS} ${SOURCES})
target_include_directories(02_tdd_lib PUBLIC include)

add_executable(02_tdd src/main.cpp)
target_link_libraries(02_tdd 02_tdd_lib)

add_subdirectory(test)
