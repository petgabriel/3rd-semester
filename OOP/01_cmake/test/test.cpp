#include <gtest/gtest.h>
#include "../runner/dummy.h"

TEST(dummy, Add)
{
    auto Dummy = dummy{};
    EXPECT_EQ(4, Dummy.add(1, 3));
}
